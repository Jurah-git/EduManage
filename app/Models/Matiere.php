<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $fillable = [
        'code',
        'nom',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION CLASSES
    |--------------------------------------------------------------------------
    */

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_matiere');
    }
}
