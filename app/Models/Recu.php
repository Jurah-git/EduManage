<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recu extends Model
{
    protected $table = 'recus';

    protected $fillable = [
        'paiement_id',
        'numero_recu',
        'date_emission',
        'observations',
    ];

    protected function casts(): array
    {
        return [
            'date_emission' => 'datetime',
        ];
    }

    // Paiement correspondant à ce reçu.
    public function paiement(): BelongsTo
    {
        return $this->belongsTo(Paiement::class, 'paiement_id');
    }
}