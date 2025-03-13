<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Permission::create(['name' => 'list monthlyreports']);
        Permission::create(['name' => 'view monthlyreports']);
        Permission::create(['name' => 'create monthlyreports']);
        Permission::create(['name' => 'update monthlyreports']);
        Permission::create(['name' => 'delete monthlyreports']);

        $dbConnection = env('DB_CONNECTION', 'mysql');
        $searchOperator = $dbConnection == 'pgsql' ? 'ilike' : 'like';
        $currentPermissions = Permission::where('name', $searchOperator, "%monthlyreports%")->get();
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        $adminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole->givePermissionTo($currentPermissions);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $dbConnection = env('DB_CONNECTION', 'mysql');
        $searchOperator = $dbConnection == 'pgsql' ? 'ilike' : 'like';
        $permissions = Permission::where('name', $searchOperator, "%monthlyreports%")->get();
        foreach ($permissions as $permission) {
            // Remove the permission from roles and users
            $permission->roles()->detach();
            $permission->users()->detach();

            // Delete the permission
            $permission->delete();
        }
    }
};
