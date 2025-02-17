<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        //  Création des rôles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        //  Création des permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete users']);

        // Assigner un rôle à un utilisateur
        $admin = User::find(1); // Remplace 1 par l’ID de ton admin
        if ($admin) {
            $admin->assignRole($adminRole);
        }
    }
}
