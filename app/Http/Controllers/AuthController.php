<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\SalonSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display the login view.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            // Si c'est un client et que le salon est en maintenance, on termine sa session client
            $settings = SalonSetting::current();
            if ($settings->mode_maintenance) {
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return view('auth.login')->with('error', '⚠️ Accès Client indisponible : ' . ($settings->message_maintenance ?: 'Le salon est temporairement en maintenance.'));
            }

            return redirect()->route('user.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * The "password" field receives the CIN (8 digits), used as password.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'digits:8'],
        ], [
            'email.required'    => 'L\'adresse email est obligatoire.',
            'email.email'       => 'Veuillez saisir une adresse email valide.',
            'password.required' => 'Le numéro CIN est obligatoire.',
            'password.digits'   => 'Le CIN doit contenir exactement 8 chiffres.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Si le mode maintenance est activé et que l'utilisateur N'EST PAS administrateur
            $settings = SalonSetting::current();
            if ($settings->mode_maintenance && !$user->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $message = $settings->message_maintenance
                    ?: 'Notre salon est temporairement fermé pour maintenance. Merci de revenir bientôt !';

                return redirect()->route('login')
                    ->with('error', '⚠️ Accès Client suspendu : ' . $message);
            }

            $request->session()->regenerate();

            return $this->redirectBasedOnRole($user)
                ->with('success', 'Connexion réussie ! Bienvenue ' . $user->name . '.');
        }

        return back()->withErrors([
            'email' => 'Email ou CIN incorrect. Veuillez réessayer.',
        ])->onlyInput('email');
    }

    /**
     * Display the registration view.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        $settings = SalonSetting::current();
        if ($settings->mode_maintenance) {
            return redirect()->route('login')->with('error', 'Le salon est actuellement en maintenance. Les inscriptions de nouveaux clients sont temporairement suspendues.');
        }

        if (!$settings->inscription_ouverte) {
            return redirect()->route('login')->with('error', 'Les inscriptions de nouveaux clients sont temporairement fermées par l\'administration du salon.');
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * CIN (8 digits) is used as password. Role is always forced to "user".
     */
    public function register(Request $request)
    {
        $settings = SalonSetting::current();
        if ($settings->mode_maintenance) {
            return redirect()->route('login')->with('error', 'Le salon est actuellement en maintenance. Les inscriptions de nouveaux clients sont temporairement suspendues.');
        }

        if (!$settings->inscription_ouverte) {
            return redirect()->route('login')->with('error', 'Les inscriptions de nouveaux clients sont temporairement fermées par l\'administration du salon.');
        }

        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'telephone'        => ['nullable', 'string', 'max:20'],
            'cin'              => ['required', 'digits:8', 'confirmed'],
            'cin_confirmation' => ['required', 'digits:8'],
        ], [
            'name.required'             => 'Le nom complet est obligatoire.',
            'email.required'            => 'L\'adresse email est obligatoire.',
            'email.email'               => 'Veuillez saisir un email valide.',
            'email.unique'              => 'Cet email est déjà utilisé.',
            'cin.required'              => 'Le numéro CIN est obligatoire.',
            'cin.digits'                => 'Le CIN doit contenir exactement 8 chiffres.',
            'cin.confirmed'             => 'Les deux numéros CIN ne correspondent pas.',
            'cin_confirmation.required' => 'La confirmation du CIN est obligatoire.',
            'cin_confirmation.digits'   => 'La confirmation du CIN doit contenir exactement 8 chiffres.',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => strtolower($request->email),
            'telephone' => $request->telephone,
            'role'      => 'user',  // Always user — admin created separately
            'password'  => $request->cin,   // hashé automatiquement par le cast 'hashed' du modèle
        ]);

        // Create linked client profile
        Client::create([
            'user_id'         => $user->id,
            'nom'             => $user->name,
            'telephone'       => $user->telephone,
            'email'           => $user->email,
            'points_fidelite' => 0,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectBasedOnRole($user)
            ->with('success', 'Compte créé avec succès ! Bienvenue, ' . $user->name . '.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /**
     * Redirect based on user role.
     */
    protected function redirectBasedOnRole(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
}
