<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Réinitialiser le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Définition des permissions avec `guard_name`
        $permissions = [
            'create articles',
            'edit articles',
            'delete articles',
            'publish articles',
            'unpublish articles'
        ];

        // Vérifier et créer les permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Création des rôles (éviter duplication)
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $user = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web'
        ]);

        // Attribution des permissions aux rôles
        $admin->syncPermissions(Permission::all()); // Admin a toutes les permissions
        $user->syncPermissions(['create articles', 'edit articles']); // Utilisateur normal a un accès limité

        // Message de confirmation
        $this->command->info('🎉 Rôles et permissions ajoutés avec succès !');
    }
}
