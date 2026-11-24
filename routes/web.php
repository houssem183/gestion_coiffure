<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

// Root route: Redirect to appropriate dashboard or login
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return $user->isAdmin() 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Authentication Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Auth Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Admin Routes (Full CRUD)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Services CRUD
    Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
    Route::put('/services/{service}', [AdminController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{service}', [AdminController::class, 'destroyService'])->name('services.destroy');

    // Coiffeurs CRUD
    Route::post('/coiffeurs', [AdminController::class, 'storeCoiffeur'])->name('coiffeurs.store');
    Route::put('/coiffeurs/{coiffeur}', [AdminController::class, 'updateCoiffeur'])->name('coiffeurs.update');
    Route::delete('/coiffeurs/{coiffeur}', [AdminController::class, 'destroyCoiffeur'])->name('coiffeurs.destroy');

    // Produits CRUD
    Route::post('/produits', [AdminController::class, 'storeProduit'])->name('produits.store');
    Route::put('/produits/{produit}', [AdminController::class, 'updateProduit'])->name('produits.update');
    Route::delete('/produits/{produit}', [AdminController::class, 'destroyProduit'])->name('produits.destroy');

    // Clients CRUD
    Route::post('/clients', [AdminController::class, 'storeClient'])->name('clients.store');
    Route::delete('/clients/{client}', [AdminController::class, 'destroyClient'])->name('clients.destroy');

    // RendezVous CRUD
    Route::patch('/rdv/{rdv}/status', [AdminController::class, 'updateRdvStatus'])->name('rdv.updateStatus');
    Route::delete('/rdv/{rdv}', [AdminController::class, 'destroyRdv'])->name('rdv.destroy');

    // Settings
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Paiements & Facturation
    Route::patch('/paiements/{paiement}/status', [AdminController::class, 'updatePaiementStatus'])->name('paiements.updateStatus');
});

// Protected User / Client Routes (Create & Cancel RDV, Profile Settings)
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/rendez-vous', [UserController::class, 'storeRendezVous'])->name('rdv.store');
    Route::delete('/rendez-vous/{rdv}', [UserController::class, 'cancelRendezVous'])->name('rdv.cancel');
    Route::post('/settings', [UserController::class, 'updateSettings'])->name('settings.update');
    Route::post('/paiement/{paiement}/pay', [UserController::class, 'payOnline'])->name('paiement.pay');
});
