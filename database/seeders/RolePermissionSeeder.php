<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissionsParModule = [
            'eleves'       => ['voir', 'creer', 'modifier', 'supprimer'],
            'classes'      => ['voir', 'creer', 'modifier', 'supprimer'],
            'matieres'     => ['voir', 'creer', 'modifier', 'supprimer'],
            'enseignants'  => ['voir', 'show', 'creer', 'modifier', 'supprimer'],

            'notes'        => ['voir', 'creer', 'modifier', 'supprimer', 'valider'],

            
            'bulletins'    => ['voir', 'creer', 'afficher', 'telecharger', 'imprimer'],

            'emploi_temps' => ['voir', 'show', 'creer', 'modifier', 'supprimer', 'valider'],
            'cahier_texte' => ['voir', 'creer', 'modifier', 'supprimer', 'valider'],
            'bibliotheque' => ['voir', 'creer', 'modifier', 'supprimer'],
            'parents'      => ['voir', 'creer', 'modifier', 'supprimer'],
            'presences'    => ['voir', 'creer', 'modifier', 'valider'],
            'inscriptions' => ['voir', 'creer', 'modifier', 'valider'],
            'paiements'    => ['voir', 'creer', 'modifier', 'supprimer', 'valider'],
            'utilisateurs' => ['voir', 'creer', 'modifier', 'supprimer'],
            'rapports'     => ['voir'],
            'periodes'     => ['voir', 'creer', 'modifier', 'supprimer'],
            'coefficients' => ['voir', 'creer', 'modifier', 'supprimer'],
            'salles'       => ['voir', 'creer', 'modifier', 'supprimer'],
        ];

        foreach ($permissionsParModule as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name'       => $module . '.' . $action,
                    'guard_name' => 'web',
                ]);
            }
        }
    }
}