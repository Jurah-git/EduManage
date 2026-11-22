<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnneeScolaire extends Model
{
    protected $fillable = [
        'nom',
        'date_debut',
        'date_fin',
        'active',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
        'active'     => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relation avec les inscriptions
    |--------------------------------------------------------------------------
    */

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class, 'annee_scolaire_id');
    }
}