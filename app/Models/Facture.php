<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'paiement_id',
        'rendez_vous_id',
        'date',
        'total',
        'tva_montant',
        'total_ttc',
        'statut',
    ];

    protected $casts = [
        'date' => 'date',
        'total' => 'decimal:2',
        'tva_montant' => 'decimal:2',
        'total_ttc' => 'decimal:2',
    ];

    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }
}
