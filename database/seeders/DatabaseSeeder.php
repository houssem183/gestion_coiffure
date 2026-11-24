<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Coiffeur;
use App\Models\Service;
use App\Models\Produit;
use App\Models\RendezVous;
use App\Models\Paiement;
use App\Models\Facture;
use Illuminate\Database\Seeder;
// Hash::make() retiré : le cast 'hashed' du modèle User applique bcrypt automatiquement

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Comptes créés :
     *  - Administrateur : admin@salon.tn / CIN: 12345678
     *  - Client demo    : user@salon.tn  / CIN: 87654321
     */
    public function run(): void
    {
        // ─── 1. COMPTE ADMINISTRATEUR ───────────────────────────────────────
        // Le compte admin est créé ici (pas accessible via le formulaire d'inscription).
        // CIN utilisé comme mot de passe : 12345678
        $admin = User::firstOrCreate(
            ['email' => 'admin@salon.tn'],
            [
                'name'      => 'Administrateur Salon',
                'telephone' => '+216 20 123 456',
                'password'  => '12345678',   // CIN = mot de passe (hashé auto par le cast 'hashed')
                'role'      => 'admin',
            ]
        );

        // ─── 2. COMPTE CLIENT DÉMONSTRATION ────────────────────────────────
        // CIN utilisé comme mot de passe : 87654321
        $user = User::firstOrCreate(
            ['email' => 'user@salon.tn'],
            [
                'name'      => 'Client Exemple',
                'telephone' => '+216 55 987 654',
                'password'  => '87654321',   // CIN = mot de passe (hashé auto par le cast 'hashed')
                'role'      => 'user',
            ]
        );

        // Profil client lié au compte user
        $client = Client::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nom'       => $user->name,
                'telephone' => $user->telephone,
                'email'     => $user->email,
            ]
        );

        // ─── 3. COIFFEURS ──────────────────────────────────────────────────
        $coiffeur1 = Coiffeur::firstOrCreate(
            ['nom' => 'Amine Khelil'],
            ['specialite' => 'Master Barber & Coupe Homme', 'disponibilite' => 'disponible', 'telephone' => '+216 22 111 222']
        );
        $coiffeur2 = Coiffeur::firstOrCreate(
            ['nom' => 'Sami Ben Ali'],
            ['specialite' => 'Coloration & Stylisme', 'disponibilite' => 'disponible', 'telephone' => '+216 22 333 444']
        );
        $coiffeur3 = Coiffeur::firstOrCreate(
            ['nom' => 'Youssef Tazi'],
            ['specialite' => 'Visagiste & Soins Barbe', 'disponibilite' => 'disponible', 'telephone' => '+216 22 555 666']
        );

        // ─── 4. SERVICES ───────────────────────────────────────────────────
        $s1 = Service::firstOrCreate(
            ['nom' => 'Coupe Homme & Barbe Prestige'],
            ['prix' => 35.00, 'duree' => 30, 'description' => 'Coupe aux ciseaux/tondeuse + soin barbe complet']
        );
        $s2 = Service::firstOrCreate(
            ['nom' => 'Coloration & Traitement Keratine'],
            ['prix' => 85.00, 'duree' => 60, 'description' => 'Coloration sur mesure et soin réparateur intense']
        );
        $s3 = Service::firstOrCreate(
            ['nom' => 'Shampooing & Massage Capillaire'],
            ['prix' => 20.00, 'duree' => 20, 'description' => 'Shampooing relaxant avec massage du cuir chevelu']
        );

        // ─── 5. PRODUITS ───────────────────────────────────────────────────
        Produit::firstOrCreate(
            ['nom' => 'Huile de Barbe Bio Argan'],
            ['prix' => 45.00, 'stock' => 15]
        );
        Produit::firstOrCreate(
            ['nom' => 'Cire Coiffante Mat Prestige'],
            ['prix' => 32.00, 'stock' => 25]
        );
        Produit::firstOrCreate(
            ['nom' => 'Shampooing Anti-Chute Keratine'],
            ['prix' => 28.00, 'stock' => 18]
        );

        // ─── 6. RENDEZ-VOUS DÉMONSTRATION ──────────────────────────────────
        $rdv = RendezVous::create([
            'user_id'     => $user->id,
            'client_id'   => $client->id,
            'coiffeur_id' => $coiffeur1->id,
            'service_id'  => $s1->id,
            'date'        => now()->addDays(1)->setHour(14)->setMinute(0),
            'statut'      => 'confirme',
            'motif'       => 'Rendez-vous régulier',
        ]);

        // ─── 7. PAIEMENT & FACTURE ─────────────────────────────────────────
        $paiement = Paiement::create([
            'rendez_vous_id' => $rdv->id,
            'montant'        => $s1->prix,
            'mode'           => 'espece',
            'date'           => now()->toDateString(),
        ]);

        Facture::create([
            'paiement_id'    => $paiement->id,
            'rendez_vous_id' => $rdv->id,
            'date'           => now()->toDateString(),
            'total'          => $s1->prix,
            'statut'         => 'payee',
        ]);
    }
}
