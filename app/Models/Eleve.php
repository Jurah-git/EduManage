<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /*
    |--------------------------------------------------------------------------
    | RELATION PARENTS
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | RELATION COMPTE UTILISATEUR
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION INSCRIPTIONS
    |--------------------------------------------------------------------------
    */

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class, 'eleve_id');
    }
}