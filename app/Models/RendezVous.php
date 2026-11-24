<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';

    protected $fillable = [
        'user_id',
        'client_id',
        'coiffeur_id',
        'service_id',
        'date',
        'statut',
        'motif',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function coiffeur()
    {
        return $this->belongsTo(Coiffeur::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }
}
