<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'matricule',
        'sexe',
        'date_naissance',
        'classe_id',
        'numero_classe',
        'photo'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION CLASSE
    |--------------------------------------------------------------------------
    */

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}