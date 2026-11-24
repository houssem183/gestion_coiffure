<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password
                            {email=admin@salon.tn : Email du compte admin}
                            {password=12345678   : Nouveau mot de passe}';

    protected $description = 'Réinitialise le mot de passe d\'un compte administrateur';

    public function handle(): int
    {
        $email    = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("Aucun utilisateur trouvé avec l'email : {$email}");
            $this->info('Création du compte admin...');

            $user = User::create([
                'name'      => 'Administrateur Salon',
                'email'     => $email,
                'telephone' => '+216 20 123 456',
                'password'  => $password,   // hashé auto via cast 'hashed'
                'role'      => 'admin',
            ]);

            $this->info("✅ Compte admin créé : {$email}");
        } else {
            // Mise à jour directe via Query Builder pour contourner d'éventuels casts
            // et éviter le double hachage si le hash en BDD est déjà corrompu.
            User::where('email', $email)->update([
                'password' => Hash::make($password),
            ]);

            $this->info("✅ Mot de passe réinitialisé pour : {$email}");
        }

        $this->table(
            ['Champ', 'Valeur'],
            [
                ['Email', $email],
                ['Mot de passe', $password],
                ['Rôle', $user->role ?? 'admin'],
            ]
        );

        return self::SUCCESS;
    }
}
