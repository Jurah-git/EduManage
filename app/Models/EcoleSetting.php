<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoleSetting extends Model
{
    protected $fillable = [
        'nom_ecole',
        'logo',
        'adresse',
        'telephone',
        'email',
        'pointage_config',
    ];

    protected $casts = [
        'pointage_config' => 'array',
    ];
}