<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coiffeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'specialite',
        'disponibilite',
        'telephone',
    ];

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }
}
