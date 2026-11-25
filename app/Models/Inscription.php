<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inscription extends Model
{
    protected $fillable = [
        'eleve_id',
        'classe_id',
        'annee_scolaire_id',
        'date_inscription',
        'type',
        'statut',
        'frais_inscription',
        'observations',
    ];

    protected $casts = [
        'date_inscription'  => 'date',
        'frais_inscription' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relation avec l'élève
    |--------------------------------------------------------------------------
    */

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation avec la classe
    |--------------------------------------------------------------------------
    */

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation avec l'année scolaire
    |--------------------------------------------------------------------------
    */

    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id');
    }
}