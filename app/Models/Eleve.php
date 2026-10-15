<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Eleve extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'matricule',
        'sexe',
        'date_naissance',
        'classe_id',
        'numero_classe',
        'photo',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION CLASSE
    |--------------------------------------------------------------------------
    */

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(
            ParentEleve::class,
            'eleve_parent',
            'eleve_id',
            'parent_id'
        )
            ->withPivot([
                'lien_parente',
                'responsable_legal',
                'contact_principal',
            ])
            ->withTimestamps();
    }
}