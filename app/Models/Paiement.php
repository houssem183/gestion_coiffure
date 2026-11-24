<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'rendez_vous_id',
        'montant',
        'mode',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }
}
