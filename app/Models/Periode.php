<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $fillable = [
        'nom',
        'date_debut',
        'date_fin'
    ];
}
