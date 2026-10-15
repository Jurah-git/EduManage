<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ParentEleve extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'telephone_secondaire',
        'email',
        'profession',
        'adresse',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function eleves(): BelongsToMany
    {
        return $this->belongsToMany(
            Eleve::class,
            'eleve_parent',
            'parent_id',
            'eleve_id'
        )
            ->withPivot([
                'lien_parente',
                'responsable_legal',
                'contact_principal',
            ])
            ->withTimestamps();
    }
}