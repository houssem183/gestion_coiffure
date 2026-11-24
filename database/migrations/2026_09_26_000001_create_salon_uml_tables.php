<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Clients
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('nom');
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        // 2. Coiffeurs
        Schema::create('coiffeurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('specialite');
            $table->string('disponibilite')->default('disponible');
            $table->string('telephone')->nullable();
            $table->timestamps();
        });

        // 3. Services
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->decimal('prix', 8, 2);
            $table->integer('duree'); // en minutes
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 4. Produits
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->decimal('prix', 8, 2);
            $table->integer('stock')->default(0);
            $table->timestamps();
        });

        // 5. Rendez-vous
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->foreignId('coiffeur_id')->nullable()->constrained('coiffeurs')->onDelete('set null');
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null');
            $table->dateTime('date');
            $table->string('statut')->default('en_attente'); // en_attente, confirme, annule, termine
            $table->text('motif')->nullable();
            $table->timestamps();
        });

        // 6. Paiements
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rendez_vous_id')->nullable()->constrained('rendez_vous')->onDelete('cascade');
            $table->decimal('montant', 8, 2);
            $table->string('mode')->default('espece'); // espece, carte, virement
            $table->date('date');
            $table->timestamps();
        });

        // 7. Factures
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paiement_id')->nullable()->constrained('paiements')->onDelete('set null');
            $table->foreignId('rendez_vous_id')->nullable()->constrained('rendez_vous')->onDelete('cascade');
            $table->date('date');
            $table->decimal('total', 8, 2);
            $table->string('statut')->default('payee'); // payee, non_payee
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
        Schema::dropIfExists('paiements');
        Schema::dropIfExists('rendez_vous');
        Schema::dropIfExists('produits');
        Schema::dropIfExists('services');
        Schema::dropIfExists('coiffeurs');
        Schema::dropIfExists('clients');
    }
};
