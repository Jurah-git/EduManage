<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmploiTemps extends Model
{
    protected $table = 'emplois_temps';

    protected $fillable = [
        'classe_id',
        'annee_scolaire_id',
        'titre',
        'statut',
    ];

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    public function creneaux(): HasMany
    {
        return $this->hasMany(CreneauEmploiTemps::class);
    }
}