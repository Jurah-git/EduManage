<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActiviteParascolaire extends Model
{
    protected $table = 'activite_parascolaires';

    protected $fillable = [
        'nom',
        'categorie',
        'description',
        'tarif_indicatif',
        'periodicite',
        'jours',
        'heure_debut',
        'heure_fin',
        'actif',
    ];

    protected $casts = [
        'tarif_indicatif' => 'decimal:2',
        'jours' => 'array',
        'actif' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION AVEC LES INSCRIPTIONS
    |--------------------------------------------------------------------------
    */

    public function inscriptions(): HasMany
    {
        return $this->hasMany(
            InscriptionActivite::class,
            'activite_parascolaire_id'
        );
    }
}
