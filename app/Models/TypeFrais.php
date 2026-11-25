<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeFrais extends Model
{
    protected $table = 'types_frais';

    protected $fillable = [
        'nom',
        'description',
        'frequence',
        'actif',
    ];

    protected function casts(): array
    {
        return [
            'actif' => 'boolean',
        ];
    }

    // Un type de frais peut avoir plusieurs tarifs.
    public function tarifs(): HasMany
    {
        return $this->hasMany(TarifFrais::class, 'type_frais_id');
    }
}