<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnulationPaiement extends Model
{
    protected $table = 'annulations_paiements';

    protected $fillable = [
        'paiement_id',
        'user_id',
        'motif',
        'date_annulation',
    ];

    protected function casts(): array
    {
        return [
            'date_annulation' => 'datetime',
        ];
    }

    // Paiement concerné par l'annulation.
    public function paiement(): BelongsTo
    {
        return $this->belongsTo(Paiement::class, 'paiement_id');
    }

    // Utilisateur ayant effectué l'annulation.
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}