<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles {
        HasRoles::hasPermissionTo as protected hasPermissionToViaSpatie;
    }

    /**
     * Champs modifiables
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'telephone',
        'sexe',
        'date_naissance',
        'adresse',
        'fonction',
        'statut',
    ];

    /**
     * Champs cachés
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversions automatiques
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_naissance' => 'date',
            'statut' => 'boolean',
        ];
    }

    /**
     * Vérification des permissions
     */
    public function hasPermissionTo($permission, $guardName = null): bool
    {
        if (
            $this->exists &&
            (
                (int) $this->id === 1 ||
                $this->hasRole('Administrateur')
            )
        ) {
            return true;
        }

        return $this->hasPermissionToViaSpatie($permission, $guardName);
    }

    /**
     * Vérification personnalisée d'une permission
     */
    public function aPermission(string $permission): bool
    {
        if (!$this->exists) {
            return false;
        }

        return $this->hasPermissionTo($permission, 'web');
    }

    /**
     * Relation avec l'élève
     */
    public function eleve(): HasOne
    {
        return $this->hasOne(Eleve::class, 'user_id');
    }

    /**
     * Relation avec le parent
     */
    public function parentEleve(): HasOne
    {
        return $this->hasOne(ParentEleve::class, 'user_id');
    }
}