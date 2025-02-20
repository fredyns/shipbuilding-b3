<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list shipbuildings']);
        Permission::create(['name' => 'view shipbuildings']);
        Permission::create(['name' => 'create shipbuildings']);
        Permission::create(['name' => 'update shipbuildings']);
        Permission::create(['name' => 'delete shipbuildings']);

        Permission::create(['name' => 'list shipbuildingtasks']);
        Permission::create(['name' => 'view shipbuildingtasks']);
        Permission::create(['name' => 'create shipbuildingtasks']);
        Permission::create(['name' => 'update shipbuildingtasks']);
        Permission::create(['name' => 'delete shipbuildingtasks']);

        Permission::create(['name' => 'list shiptypes']);
        Permission::create(['name' => 'view shiptypes']);
        Permission::create(['name' => 'create shiptypes']);
        Permission::create(['name' => 'update shiptypes']);
        Permission::create(['name' => 'delete shiptypes']);

        Permission::create(['name' => 'list shipyards']);
        Permission::create(['name' => 'view shipyards']);
        Permission::create(['name' => 'create shipyards']);
        Permission::create(['name' => 'update shipyards']);
        Permission::create(['name' => 'delete shipyards']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
