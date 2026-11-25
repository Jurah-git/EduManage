<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TarifFrais extends Model
{
    protected $table = 'tarifs_frais';

    protected $fillable = [
        'type_frais_id',
        'annee_scolaire_id',
        'classe_id',
        'montant',
        'date_debut',
        'date_fin',
        'actif',
    ];

    protected function casts(): array
    {
        return [
            'montant'    => 'decimal:2',
            'date_debut' => 'date',
            'date_fin'   => 'date',
            'actif'      => 'boolean',
        ];
    }

    // Type de frais associé.
    public function typeFrais(): BelongsTo
    {
        return $this->belongsTo(TypeFrais::class, 'type_frais_id');
    }

    // Année scolaire concernée.
    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id');
    }

    // Classe concernée.
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    // Frais générés pour les élèves.
    public function elevesFrais(): HasMany
    {
        return $this->hasMany(EleveFrais::class, 'tarif_frais_id');
    }
}