<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPaiement extends Model
{
    protected $table = 'details_paiements';

    protected $fillable = [
        'paiement_id',
        'eleve_frais_id',
        'montant_paye',
    ];

    protected function casts(): array
    {
        return [
            'montant_paye' => 'decimal:2',
        ];
    }

    // Paiement auquel appartient ce détail.
    public function paiement(): BelongsTo
    {
        return $this->belongsTo(Paiement::class, 'paiement_id');
    }

    // Frais de l'élève réglé par ce paiement.
    public function eleveFrais(): BelongsTo
    {
        return $this->belongsTo(EleveFrais::class, 'eleve_frais_id');
    }
}