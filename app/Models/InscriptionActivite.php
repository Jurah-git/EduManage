<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InscriptionActivite extends Model
{
    // Nom exact de la table créée par la migration.
    protected $table = 'inscriptions_activites';

    protected $fillable = [
        'eleve_id',
        'activite_parascolaire_id',
        'annee_scolaire_id',
        'date_demande',
        'tarif_applique',
        'statut',
        'observations',
    ];

    protected $casts = [
        'date_demande' => 'date',
        'tarif_applique' => 'decimal:2',
    ];

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class, 'eleve_id');
    }

    public function activite(): BelongsTo
    {
        return $this->belongsTo(
            ActiviteParascolaire::class,
            'activite_parascolaire_id'
        );
    }

    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(
            AnneeScolaire::class,
            'annee_scolaire_id'
        );
    }
}
