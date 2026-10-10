<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'telephone',
        'email',
        'adresse',
        'diplome',
        'specialite',
        'date_recrutement',
        'statut',
        'photo',
    ];

    protected function casts(): array
    {
        return [
            'date_naissance'   => 'date',
            'date_recrutement' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (Enseignant $enseignant) {
            if (empty($enseignant->matricule)) {
                $enseignant->matricule = 'ENS-'
                . str_pad((string) $enseignant->id, 4, '0', STR_PAD_LEFT);

                $enseignant->saveQuietly();
            }
        });
    }
}
