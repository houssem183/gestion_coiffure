<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salon_settings', function (Blueprint $table) {
            $table->id();

            // ── Profil & Coordonnées ────────────────────────────────────────
            $table->string('salon_name')->default('SalonTime');
            $table->string('slogan')->nullable();
            $table->text('description')->nullable();
            $table->string('telephone')->nullable();
            $table->string('telephone2')->nullable();
            $table->string('email')->nullable();
            $table->string('adresse')->nullable();
            $table->string('ville')->default('Tunis');
            $table->string('code_postal')->nullable();

            // ── Horaires ───────────────────────────────────────────────────
            $table->string('horaire_lun_ven')->default('09:00 - 20:00');
            $table->string('horaire_samedi')->default('09:00 - 18:00');
            $table->string('horaire_dimanche')->default('Sur rendez-vous uniquement');
            $table->boolean('ferme_dimanche')->default(false);

            // ── Réservations & Politique ────────────────────────────────────
            $table->integer('duree_min_rdv')->default(15);          // minutes
            $table->integer('delai_annulation_h')->default(2);       // heures avant rdv
            $table->integer('nb_fauteuils')->default(4);
            $table->boolean('inscription_ouverte')->default(true);
            $table->boolean('rdv_en_ligne')->default(true);
            $table->integer('max_rdv_par_jour')->default(30);

            // ── Facturation & Finance ──────────────────────────────────────
            $table->string('devise')->default('DT');
            $table->decimal('tva', 5, 2)->default(19.00);
            $table->string('prefixe_facture')->default('F');
            $table->boolean('tva_applicable')->default(false);

            // ── Fidélité & Récompenses ─────────────────────────────────────
            $table->boolean('programme_fidelite')->default(true);
            $table->integer('points_par_visite')->default(10);
            $table->integer('points_pour_reduction')->default(100);  // pts = 1 DT de remise
            $table->decimal('valeur_point', 5, 3)->default(0.010);  // 0.01 DT / point

            // ── Notifications ──────────────────────────────────────────────
            $table->boolean('notif_sms')->default(false);
            $table->boolean('notif_email')->default(false);
            $table->integer('rappel_rdv_h')->default(24);            // heures avant rappel
            $table->string('sms_expediteur')->nullable();

            // ── Réseaux Sociaux ────────────────────────────────────────────
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('google_maps')->nullable();

            // ── Sécurité & Accès ──────────────────────────────────────────
            $table->boolean('mode_maintenance')->default(false);
            $table->text('message_maintenance')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salon_settings');
    }
};
