<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Annonce extends Model
{
    protected $table = 'annonces';

    protected $fillable = [
        'titre',
        'categorie',
        'contenu',
        'statut',
        'public_cible',
        'date_publication',
        'user_id',
    ];

    protected $casts = [
        'date_publication' => 'datetime',
    ];

    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lecturesParents(): HasMany
    {
        return $this->hasMany(AnnonceParentLue::class, 'annonce_id');
    }
}
