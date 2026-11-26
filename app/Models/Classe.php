<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    protected $fillable = [
        'nom',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relation avec les élèves
    |--------------------------------------------------------------------------
    */

    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation avec les matières
    |--------------------------------------------------------------------------
    */

    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'classe_matiere')
            ->withPivot('ordre')
            ->withTimestamps()
            ->orderByPivot('ordre', 'asc');
    }

    /*
    |--------------------------------------------------------------------------
    | Relation avec les inscriptions
    |--------------------------------------------------------------------------
    */

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class, 'classe_id');
    }
}