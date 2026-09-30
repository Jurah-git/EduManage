<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'date_fin' => 'date',
        'active' => 'boolean',
    ];
}