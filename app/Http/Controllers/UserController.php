<?php

namespace App\Http\Controllers;

use App\Models\Coiffeur;
use App\Models\Service;
use App\Models\RendezVous;
use App\Models\Paiement;
use App\Models\Facture;
use App\Models\SalonSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $userRdv = RendezVous::with(['coiffeur', 'service', 'paiement', 'facture'])
            ->where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        $coiffeurs = Coiffeur::where('disponibilite', 'disponible')->get();
        $services = Service::all();
        $settings = SalonSetting::current();

        return view('user.dashboard', compact('user', 'userRdv', 'coiffeurs', 'services', 'settings'));
    }

    public function storeRendezVous(Request $request)
    {
        $settings = SalonSetting::current();

        // 1. Contrôle : RDV en ligne activé
        if (!$settings->rdv_en_ligne) {
            return back()->withErrors([
                'rdv' => "La prise de rendez-vous en ligne est actuellement désactivée par le salon. Veuillez nous contacter directement au " . ($settings->telephone ?: 'notre standard') . "."
            ])->withInput();
        }

        $request->validate([
            'coiffeur_id' => 'required|exists:coiffeurs,id',
            'service_id'  => 'required|exists:services,id',
            'date'        => 'required|date|after:now',
            'motif'       => 'nullable|string|max:500',
        ], [
            'coiffeur_id.required' => 'Veuillez sélectionner un coiffeur.',
            'service_id.required'  => 'Veuillez choisir un service.',
            'date.required'        => 'La date et l\'heure du rendez-vous sont obligatoires.',
            'date.after'           => 'La date du rendez-vous doit être ultérieure à maintenant.',
        ]);

        $service = Service::findOrFail($request->service_id);
        $coiffeur = Coiffeur::findOrFail($request->coiffeur_id);

        $requestedStart = Carbon::parse($request->date);
        $requestedEnd = $requestedStart->copy()->addMinutes($service->duree);

        // 2. Contrôle : Fermé le dimanche
        if ($settings->ferme_dimanche && $requestedStart->isSunday()) {
            return back()->withErrors([
                'date' => "Le salon est fermé le dimanche selon les horaires d'ouverture. Veuillez choisir un créneau du Lundi au Samedi."
            ])->withInput();
        }

        // 3. Contrôle : Durée minimale acceptée
        if ($settings->duree_min_rdv && $service->duree < $settings->duree_min_rdv) {
            return back()->withErrors([
                'service_id' => "La durée minimale pour une prestation est de {$settings->duree_min_rdv} minutes."
            ])->withInput();
        }

        // 4. Contrôle : Max RDV par jour
        if ($settings->max_rdv_par_jour) {
            $countToday = RendezVous::whereDate('date', $requestedStart->toDateString())
                ->where('statut', '!=', 'annule')
                ->count();
            if ($countToday >= $settings->max_rdv_par_jour) {
                return back()->withErrors([
                    'date' => "Le quota journalier maximal ({$settings->max_rdv_par_jour} RDV) est atteint pour cette date. Veuillez choisir un autre jour."
                ])->withInput();
            }
        }

        // 5. Contrôle : Coiffeur disponible
        if ($coiffeur->disponibilite !== 'disponible') {
            return back()->withErrors([
                'coiffeur_id' => 'Ce coiffeur est actuellement indisponible (occupé ou en congé).'
            ])->withInput();
        }

        // 6. Contrôle : Collision horaire pour ce coiffeur
        $existingRdvs = RendezVous::with('service')
            ->where('coiffeur_id', $request->coiffeur_id)
            ->where('statut', '!=', 'annule')
            ->whereDate('date', $requestedStart->toDateString())
            ->get();

        foreach ($existingRdvs as $exist) {
            $existStart = Carbon::parse($exist->date);
            $existDuration = $exist->service ? $exist->service->duree : 30;
            $existEnd = $existStart->copy()->addMinutes($existDuration);

            if ($requestedStart < $existEnd && $requestedEnd > $existStart) {
                return back()->withErrors([
                    'date' => 'Ce créneau horaire est déjà réservé pour ' . $coiffeur->nom . ' (' 
                        . $existStart->format('H:i') . ' - ' . $existEnd->format('H:i') 
                        . '). Veuillez choisir une autre heure ou un autre coiffeur.'
                ])->withInput();
            }
        }

        // 7. Contrôle : Capacité des fauteuils en simultané dans le salon
        if ($settings->nb_fauteuils) {
            $allActiveSameDay = RendezVous::with('service')
                ->where('statut', '!=', 'annule')
                ->whereDate('date', $requestedStart->toDateString())
                ->get();

            $overlapChairs = $allActiveSameDay->filter(function ($r) use ($requestedStart, $requestedEnd) {
                $rStart = Carbon::parse($r->date);
                $rDuration = $r->service ? $r->service->duree : 30;
                $rEnd = $rStart->copy()->addMinutes($rDuration);
                return ($requestedStart < $rEnd && $requestedEnd > $rStart);
            })->count();

            if ($overlapChairs >= $settings->nb_fauteuils) {
                return back()->withErrors([
                    'date' => "Tous les fauteuils du salon ({$settings->nb_fauteuils}) sont réservés sur ce créneau. Veuillez décaler l'heure de votre passage."
                ])->withInput();
            }
        }

        $user = Auth::user();
        $client = $user->clientProfile;

        $modePaiement = $request->input('mode_paiement', 'espece');
        $statutFacture = in_array($modePaiement, ['carte', 'en_ligne']) ? 'payee' : 'non_payee';

        $rdv = RendezVous::create([
            'user_id'     => $user->id,
            'client_id'   => $client ? $client->id : null,
            'coiffeur_id' => $request->coiffeur_id,
            'service_id'  => $request->service_id,
            'date'        => $request->date,
            'statut'      => 'en_attente',
            'motif'       => $request->motif,
        ]);

        $paiement = Paiement::create([
            'rendez_vous_id' => $rdv->id,
            'montant'        => $service->prix,
            'mode'           => $modePaiement,
            'date'           => date('Y-m-d', strtotime($request->date)),
        ]);

        // 8. Calcul Facture avec TVA et préfixe configurés par l'admin
        $prefix = $settings->prefixe_facture ?: 'F';
        $reference = sprintf('%s-%s-%04d', $prefix, date('Y'), $rdv->id);

        $totalTtc = (float) $service->prix;
        if ($settings->tva_applicable && $settings->tva > 0) {
            $tauxTva = (float) $settings->tva;
            $totalHt = round($totalTtc / (1 + ($tauxTva / 100)), 3);
            $tvaMontant = round($totalTtc - $totalHt, 3);
        } else {
            $totalHt = $totalTtc;
            $tvaMontant = 0.0;
        }

        Facture::create([
            'reference'      => $reference,
            'paiement_id'    => $paiement->id,
            'rendez_vous_id' => $rdv->id,
            'date'           => date('Y-m-d', strtotime($request->date)),
            'total'          => $totalHt,
            'tva_montant'    => $tvaMontant,
            'total_ttc'      => $totalTtc,
            'statut'         => $statutFacture,
        ]);

        // 9. Créditer le programme de fidélité si payé immédiatement
        if ($statutFacture === 'payee' && $settings->programme_fidelite && $settings->points_par_visite > 0 && $client) {
            $client->increment('points_fidelite', (int) $settings->points_par_visite);
        }

        $devise = $settings->devise ?? 'DT';
        $message = "Votre réservation a été enregistrée avec succès ! (Réf: {$reference})";
        if ($settings->notif_sms || $settings->notif_email) {
            $message .= " Un message de confirmation vous a été envoyé.";
        }

        return back()->with('success', $message);
    }

    public function cancelRendezVous(RendezVous $rdv)
    {
        $user = Auth::user();

        if ($rdv->user_id !== $user->id) {
            return back()->with('error', 'Action non autorisée.');
        }

        $settings = SalonSetting::current();

        // Contrôle : Délai d'annulation avant RDV
        if ($settings->delai_annulation_h) {
            $rdvTime = Carbon::parse($rdv->date);
            if ($rdvTime->isFuture()) {
                $hoursDiff = now()->diffInHours($rdvTime, false);
                if ($hoursDiff < $settings->delai_annulation_h) {
                    return back()->with('error', "L'annulation en ligne n'est plus autorisée car elle doit intervenir au moins {$settings->delai_annulation_h}h avant le rendez-vous. Merci de joindre le salon au " . ($settings->telephone ?: 'standard') . ".");
                }
            }
        }

        $rdv->update(['statut' => 'annule']);

        return back()->with('success', 'Rendez-vous annulé avec succès !');
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'cin'   => 'required|string|size:8|unique:users,cin,' . $user->id,
        ], [
            'name.required'  => 'Le nom complet est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.unique'   => 'Cet email est déjà utilisé par un autre compte.',
            'cin.required'   => 'Le numéro CIN est obligatoire.',
            'cin.size'       => 'Le CIN doit comporter exactement 8 chiffres.',
            'cin.unique'     => 'Ce numéro CIN est déjà enregistré.',
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'cin'      => $request->cin,
            'password' => bcrypt($request->cin),
        ]);

        if ($user->clientProfile) {
            $user->clientProfile->update([
                'nom'   => $request->name,
                'email' => $request->email,
            ]);
        }

        return back()->with('success', 'Vos paramètres de profil ont été mis à jour avec succès !');
    }

    public function payOnline(Request $request, Paiement $paiement)
    {
        $user = Auth::user();

        if ($paiement->rendezVous && $paiement->rendezVous->user_id !== $user->id) {
            return back()->with('error', 'Action non autorisée.');
        }

        $mode = $request->input('mode_paiement', 'carte');
        $paiement->update(['mode' => $mode]);

        if ($paiement->facture) {
            $paiement->facture->update(['statut' => 'payee']);
        }

        $settings = SalonSetting::current();
        $devise = $settings->devise ?? 'DT';

        // Créditer les points de fidélité
        if ($settings->programme_fidelite && $settings->points_par_visite > 0 && $user->clientProfile) {
            $user->clientProfile->increment('points_fidelite', (int) $settings->points_par_visite);
        }

        return back()->with('success', 'Paiement de ' . number_format($paiement->montant, 2) . ' ' . $devise . ' effectué avec succès ! Votre facture est réglée.');
    }
}
