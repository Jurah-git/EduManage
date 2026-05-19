<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClasseMatiereCoefficient
extends Model
{

    protected $fillable = [

        'classe_id',

        'matiere_id',

        'coef'

    ];

}