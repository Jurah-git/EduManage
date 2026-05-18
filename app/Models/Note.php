<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'eleve_id',
        'matiere_id',
        'periode_id',
        'type',
        'valeur',
        'coef',
        'base',
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}