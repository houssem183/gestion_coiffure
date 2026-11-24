<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->decimal('tva_montant', 8, 2)->default(0)->after('total');
            $table->decimal('total_ttc', 8, 2)->default(0)->after('tva_montant');
            $table->string('reference')->nullable()->after('id'); // ex: F-2026-001
        });
    }

    public function down(): void
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->dropColumn(['tva_montant', 'total_ttc', 'reference']);
        });
    }
};
