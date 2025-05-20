<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyer le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions listées par domaine
        $permissions = [
            // Clients
            'view all clients',
            'view own hotel clients',
            'create clients',
            'edit clients',
            'delete clients',

            // Séjours
            'view all stays',
            'view own hotel stays',
            'create stays',
            'edit stays',
            'delete stays',

            // Enregistrements
            'view all registrations',
            'view own hotel registrations',
            'create registrations',
            'edit registrations',
            'delete registrations',

            // Hôtels
            'view hotels',
            'create hotels',
            'edit hotels',
            'delete hotels',

            // Utilisateurs et rôles
            'view users',
            'create users',
            'edit users',
            'delete users',
            'assign roles',
            'revoke roles',
        ];

        // Créer les permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Créer les rôles
        $roles = [
            'Super Admin',
            'Ministry Admin',
            'Inspector',
            'Hotel Manager',
            'Receptionist',
            'Guest',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Attribution des permissions par rôle

        // Super Admin => toutes les permissions
        Role::findByName('Super Admin')->givePermissionTo(Permission::all());

        // Ministry Admin
        Role::findByName('Ministry Admin')->givePermissionTo([
            'view all clients',
            'view all stays',
            'view all registrations',
            'view hotels',
            'create hotels',
            'edit hotels',
            'delete hotels',
            'view users',
            'create users',
            'edit users',
            'delete users',
            'assign roles',
            'revoke roles',
        ]);

        // Inspector
        Role::findByName('Inspector')->givePermissionTo([
            'view all clients',
            'view all stays',
            'view all registrations',
            'view hotels',
        ]);

        // Hotel Manager
        Role::findByName('Hotel Manager')->givePermissionTo([
            'view own hotel clients',
            'create clients',
            'edit clients',
            'delete clients',

            'view own hotel stays',
            'create stays',
            'edit stays',
            'delete stays',

            'view own hotel registrations',
            'create registrations',
            'edit registrations',
            'delete registrations',

            'view hotels',
            'view users',
            'create users',
            'edit users',
        ]);

        // Receptionist
        Role::findByName('Receptionist')->givePermissionTo([
            'view own hotel clients',
            'create clients',
            'edit clients',

            'view own hotel stays',
            'create stays',
            'edit stays',

            'view own hotel registrations',
            'create registrations',
            'edit registrations',
        ]);

        // Guest
        Role::findByName('Guest')->givePermissionTo([
            'create clients',
        ]);
    }
}
