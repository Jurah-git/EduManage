<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EleveFrais extends Model
{
    protected $table = 'eleves_frais';

    protected $fillable = [
        'eleve_id',
        'tarif_frais_id',
        'libelle',
        'cle_periode',
        'montant_du',
        'mois',
        'annee',
        'date_echeance',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'montant_du'    => 'decimal:2',
            'date_echeance' => 'date',
            'mois'          => 'integer',
            'annee'         => 'integer',
        ];
    }

    // Élève concerné.
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class, 'eleve_id');
    }

    // Tarif à l'origine de ce frais.
    public function tarifFrais(): BelongsTo
    {
        return $this->belongsTo(TarifFrais::class, 'tarif_frais_id');
    }

    // Détails des paiements affectés à ce frais.
    public function detailsPaiements(): HasMany
    {
        return $this->hasMany(DetailPaiement::class, 'eleve_frais_id');
    }
}