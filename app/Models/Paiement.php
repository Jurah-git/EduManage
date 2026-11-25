<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Paiement extends Model
{
    protected $table = 'paiements';

    protected $fillable = [
        'numero_paiement',
        'eleve_id',
        'user_id',
        'date_paiement',
        'montant_total',
        'mode_paiement',
        'statut',
        'observations',
    ];

    protected function casts(): array
    {
        return [
            'date_paiement' => 'datetime',
            'montant_total' => 'decimal:2',
        ];
    }

    // Élève concerné par le paiement.
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class, 'eleve_id');
    }

    // Utilisateur ayant encaissé le paiement.
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Répartition du paiement entre les frais.
    public function details(): HasMany
    {
        return $this->hasMany(DetailPaiement::class, 'paiement_id');
    }

    // Reçu associé au paiement.
    public function recu(): HasOne
    {
        return $this->hasOne(Recu::class, 'paiement_id');
    }

    // Historique de l'annulation éventuelle.
    public function annulation(): HasOne
    {
        return $this->hasOne(AnnulationPaiement::class, 'paiement_id');
    }
}