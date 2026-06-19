<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{

    protected $fillable = [

        'eleve_id',

        'image_base64',

        'periodes_ids',

    ];
}
