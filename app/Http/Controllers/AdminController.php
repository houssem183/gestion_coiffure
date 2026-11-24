<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Coiffeur;
use App\Models\Service;
use App\Models\Produit;
use App\Models\RendezVous;
use App\Models\Paiement;
use App\Models\Facture;
use App\Models\SalonSetting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_clients' => Client::count(),
            'total_coiffeurs' => Coiffeur::count(),
            'total_services' => Service::count(),
            'total_produits' => Produit::count(),
            'total_rdv' => RendezVous::count(),
            'total_recette' => Paiement::sum('montant'),
            'rdv_aujourdhui' => RendezVous::whereDate('date', now()->toDateString())->count(),
        ];

        $recentRdv = RendezVous::with(['user', 'client', 'coiffeur', 'service'])
            ->orderBy('date', 'desc')
            ->take(15)
            ->get();

        $coiffeurs = Coiffeur::all();
        $services = Service::all();
        $produits = Produit::all();
        $clients = Client::latest()->get();
        $paiements = Paiement::with(['rendezVous.user', 'rendezVous.service', 'facture'])
            ->orderBy('created_at', 'desc')
            ->get();
        $settings = SalonSetting::current();

        return view('admin.dashboard', compact('stats', 'recentRdv', 'coiffeurs', 'services', 'produits', 'clients', 'paiements', 'settings'));
    }

    /* ─── SERVICES CRUD ─── */
    public function storeService(Request $request)
    {
        $settings = SalonSetting::current();
        $minDuree = $settings->duree_min_rdv ?? 5;

        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'duree' => 'required|integer|min:' . $minDuree,
            'description' => 'nullable|string',
        ], [
            'duree.min' => "La durée doit être d'au moins {$minDuree} minutes (selon les paramètres du salon).",
        ]);

        Service::create($request->all());

        return back()->with('success', 'Service ajouté avec succès !');
    }

    public function updateService(Request $request, Service $service)
    {
        $settings = SalonSetting::current();
        $minDuree = $settings->duree_min_rdv ?? 5;

        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'duree' => 'required|integer|min:' . $minDuree,
            'description' => 'nullable|string',
        ], [
            'duree.min' => "La durée doit être d'au moins {$minDuree} minutes (selon les paramètres du salon).",
        ]);

        $service->update($request->all());

        return back()->with('success', 'Service mis à jour avec succès !');
    }

    public function destroyService(Service $service)
    {
        $service->delete();
        return back()->with('success', 'Service supprimé avec succès !');
    }

    /* ─── COIFFEURS CRUD ─── */
    public function storeCoiffeur(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'disponibilite' => 'nullable|string|in:disponible,occupe,conge',
        ]);

        Coiffeur::create($request->all());

        return back()->with('success', 'Coiffeur ajouté avec succès !');
    }

    public function updateCoiffeur(Request $request, Coiffeur $coiffeur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'disponibilite' => 'required|string|in:disponible,occupe,conge',
        ]);

        $coiffeur->update($request->all());

        return back()->with('success', 'Coiffeur mis à jour avec succès !');
    }

    public function destroyCoiffeur(Coiffeur $coiffeur)
    {
        $coiffeur->delete();
        return back()->with('success', 'Coiffeur supprimé avec succès !');
    }

    /* ─── PRODUITS CRUD ─── */
    public function storeProduit(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Produit::create($request->all());

        return back()->with('success', 'Produit ajouté au stock avec succès !');
    }

    public function updateProduit(Request $request, Produit $produit)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $produit->update($request->all());

        return back()->with('success', 'Produit mis à jour avec succès !');
    }

    public function destroyProduit(Produit $produit)
    {
        $produit->delete();
        return back()->with('success', 'Produit supprimé avec succès !');
    }

    /* ─── CLIENTS CRUD ─── */
    public function storeClient(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Client::create($request->all());

        return back()->with('success', 'Client créé avec succès !');
    }

    public function destroyClient(Client $client)
    {
        $client->delete();
        return back()->with('success', 'Client supprimé avec succès !');
    }

    /* ─── RENDEZ-VOUS CRUD ─── */
    public function updateRdvStatus(Request $request, RendezVous $rdv)
    {
        $request->validate([
            'statut' => 'required|string|in:en_attente,confirme,en_cours,termine,annule',
        ]);

        $oldStatut = $rdv->statut;
        $rdv->update(['statut' => $request->statut]);

        // Si le statut passe à "termine", créditer les points de fidélité au client si activé
        if ($oldStatut !== 'termine' && $request->statut === 'termine') {
            $settings = SalonSetting::current();
            if ($settings->programme_fidelite && $settings->points_par_visite > 0) {
                $client = $rdv->client ?? ($rdv->user ? $rdv->user->clientProfile : null);
                if ($client) {
                    $client->increment('points_fidelite', (int) $settings->points_par_visite);
                }
            }
        }

        return back()->with('success', 'Statut du rendez-vous mis à jour !');
    }

    public function destroyRdv(RendezVous $rdv)
    {
        $rdv->delete();
        return back()->with('success', 'Rendez-vous supprimé avec succès !');
    }

    /* ─── PARAMÈTRES SALON ─── */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'salon_name'           => 'required|string|max:255',
            'slogan'               => 'nullable|string|max:255',
            'description'          => 'nullable|string|max:1000',
            'telephone'            => 'nullable|string|max:25',
            'telephone2'           => 'nullable|string|max:25',
            'email'                => 'nullable|email|max:255',
            'adresse'              => 'nullable|string|max:255',
            'ville'                => 'nullable|string|max:100',
            'code_postal'          => 'nullable|string|max:10',
            'horaire_lun_ven'      => 'nullable|string|max:50',
            'horaire_samedi'       => 'nullable|string|max:50',
            'horaire_dimanche'     => 'nullable|string|max:50',
            'duree_min_rdv'        => 'nullable|integer|min:5|max:240',
            'delai_annulation_h'   => 'nullable|integer|min:0|max:72',
            'nb_fauteuils'         => 'nullable|integer|min:1|max:50',
            'max_rdv_par_jour'     => 'nullable|integer|min:1|max:200',
            'prefixe_facture'      => 'nullable|string|max:10',
            'tva'                  => 'nullable|numeric|min:0|max:100',
            'points_par_visite'    => 'nullable|integer|min:0',
            'points_pour_reduction'=> 'nullable|integer|min:1',
            'valeur_point'         => 'nullable|numeric|min:0',
            'rappel_rdv_h'         => 'nullable|integer|min:1|max:72',
            'sms_expediteur'       => 'nullable|string|max:20',
            'facebook'             => 'nullable|string|max:255',
            'instagram'            => 'nullable|string|max:255',
            'google_maps'          => 'nullable|string|max:500',
            'message_maintenance'  => 'nullable|string|max:500',
        ]);

        $settings = SalonSetting::current();

        $settings->update([
            // Profil
            'salon_name'            => $request->salon_name,
            'slogan'                => $request->slogan,
            'description'           => $request->description,
            'telephone'             => $request->telephone,
            'telephone2'            => $request->telephone2,
            'email'                 => $request->email,
            'adresse'               => $request->adresse,
            'ville'                 => $request->ville,
            'code_postal'           => $request->code_postal,
            // Horaires
            'horaire_lun_ven'       => $request->horaire_lun_ven,
            'horaire_samedi'        => $request->horaire_samedi,
            'horaire_dimanche'      => $request->horaire_dimanche,
            'ferme_dimanche'        => $request->boolean('ferme_dimanche'),
            // Réservations
            'duree_min_rdv'         => $request->duree_min_rdv ?? 15,
            'delai_annulation_h'    => $request->delai_annulation_h ?? 2,
            'nb_fauteuils'          => $request->nb_fauteuils ?? 4,
            'inscription_ouverte'   => $request->boolean('inscription_ouverte'),
            'rdv_en_ligne'          => $request->boolean('rdv_en_ligne'),
            'max_rdv_par_jour'      => $request->max_rdv_par_jour ?? 30,
            // Finance
            'prefixe_facture'       => $request->prefixe_facture ?? 'F',
            'tva'                   => $request->tva ?? 19.00,
            'tva_applicable'        => $request->boolean('tva_applicable'),
            // Fidélité
            'programme_fidelite'    => $request->boolean('programme_fidelite'),
            'points_par_visite'     => $request->points_par_visite ?? 10,
            'points_pour_reduction' => $request->points_pour_reduction ?? 100,
            'valeur_point'          => $request->valeur_point ?? 0.010,
            // Notifications
            'notif_sms'             => $request->boolean('notif_sms'),
            'notif_email'           => $request->boolean('notif_email'),
            'rappel_rdv_h'          => $request->rappel_rdv_h ?? 24,
            'sms_expediteur'        => $request->sms_expediteur,
            // Réseaux Sociaux
            'facebook'              => $request->facebook,
            'instagram'             => $request->instagram,
            'google_maps'           => $request->google_maps,
            // Sécurité
            'mode_maintenance'      => $request->boolean('mode_maintenance'),
            'message_maintenance'   => $request->message_maintenance,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'tab-admin-settings'])
            ->with('success', '✅ Paramètres du salon enregistrés et activés avec succès !');
    }

    /* ─── PAIEMENTS & FACTURATION ─── */
    public function updatePaiementStatus(Request $request, Paiement $paiement)
    {
        $request->validate([
            'statut' => 'required|string|in:payee,non_payee,remboursee',
            'mode' => 'nullable|string|in:espece,carte,en_ligne',
        ]);

        if ($request->has('mode') && !empty($request->mode)) {
            $paiement->update(['mode' => $request->mode]);
        }

        if ($paiement->facture) {
            $oldStatut = $paiement->facture->statut;
            $paiement->facture->update(['statut' => $request->statut]);

            // Si la facture devient payée, créditer les points si le programme fidélité est activé
            if ($oldStatut !== 'payee' && $request->statut === 'payee') {
                $settings = SalonSetting::current();
                if ($settings->programme_fidelite && $settings->points_par_visite > 0) {
                    $rdv = $paiement->rendezVous;
                    $client = $rdv ? ($rdv->client ?? ($rdv->user ? $rdv->user->clientProfile : null)) : null;
                    if ($client) {
                        $client->increment('points_fidelite', (int) $settings->points_par_visite);
                    }
                }
            }
        }

        return back()->with('success', 'Statut du paiement et de la facture mis à jour avec succès !');
    }
}
