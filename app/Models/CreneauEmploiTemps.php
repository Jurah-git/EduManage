<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreneauEmploiTemps extends Model
{
    protected $table = 'creneaux_emploi_temps';

    protected $fillable = [
        'emploi_temps_id',
        'matiere_id',
        'enseignant_id',
        'salle_id',
        'jour',
        'heure_debut',
        'heure_fin',
    ];

    public function emploiTemps(): BelongsTo
    {
        return $this->belongsTo(EmploiTemps::class);
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function salle(): BelongsTo
    {
        return $this->belongsTo(Salle::class);
    }
}