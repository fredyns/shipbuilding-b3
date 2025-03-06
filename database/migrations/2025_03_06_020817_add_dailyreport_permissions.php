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
        // Create default permissions
        Permission::create(['name' => 'list dailyactivities']);
        Permission::create(['name' => 'view dailyactivities']);
        Permission::create(['name' => 'create dailyactivities']);
        Permission::create(['name' => 'update dailyactivities']);
        Permission::create(['name' => 'delete dailyactivities']);

        Permission::create(['name' => 'list dailydocumetations']);
        Permission::create(['name' => 'view dailydocumetations']);
        Permission::create(['name' => 'create dailydocumetations']);
        Permission::create(['name' => 'update dailydocumetations']);
        Permission::create(['name' => 'delete dailydocumetations']);

        Permission::create(['name' => 'list dailyequipments']);
        Permission::create(['name' => 'view dailyequipments']);
        Permission::create(['name' => 'create dailyequipments']);
        Permission::create(['name' => 'update dailyequipments']);
        Permission::create(['name' => 'delete dailyequipments']);

        Permission::create(['name' => 'list dailymaterials']);
        Permission::create(['name' => 'view dailymaterials']);
        Permission::create(['name' => 'create dailymaterials']);
        Permission::create(['name' => 'update dailymaterials']);
        Permission::create(['name' => 'delete dailymaterials']);

        Permission::create(['name' => 'list dailypersonnels']);
        Permission::create(['name' => 'view dailypersonnels']);
        Permission::create(['name' => 'create dailypersonnels']);
        Permission::create(['name' => 'update dailypersonnels']);
        Permission::create(['name' => 'delete dailypersonnels']);

        Permission::create(['name' => 'list dailyreports']);
        Permission::create(['name' => 'view dailyreports']);
        Permission::create(['name' => 'create dailyreports']);
        Permission::create(['name' => 'update dailyreports']);
        Permission::create(['name' => 'delete dailyreports']);

        Permission::create(['name' => 'list humidities']);
        Permission::create(['name' => 'view humidities']);
        Permission::create(['name' => 'create humidities']);
        Permission::create(['name' => 'update humidities']);
        Permission::create(['name' => 'delete humidities']);

        Permission::create(['name' => 'list weathers']);
        Permission::create(['name' => 'view weathers']);
        Permission::create(['name' => 'create weathers']);
        Permission::create(['name' => 'update weathers']);
        Permission::create(['name' => 'delete weathers']);

        Permission::create(['name' => 'list weeklydocumentations']);
        Permission::create(['name' => 'view weeklydocumentations']);
        Permission::create(['name' => 'create weeklydocumentations']);
        Permission::create(['name' => 'update weeklydocumentations']);
        Permission::create(['name' => 'delete weeklydocumentations']);

        $dbConnection = env('DB_CONNECTION', 'mysql');
        $searchOperator = $dbConnection == 'pgsql' ? 'ilike' : 'like';
        $currentPermissions = Permission::where('name', $searchOperator, "%daily%")
            ->where('name', $searchOperator, "%humidities%")
            ->where('name', $searchOperator, "%weathers%")
            ->where('name', $searchOperator, "%weeklydocumentations%")
            ->get();

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
        $olds = Permission::where('name', $searchOperator, "%daily%")
            ->orWhere('name', $searchOperator, "%humidities%")
            ->orWhere('name', $searchOperator, "%weathers%")
            ->orWhere('name', $searchOperator, "%weeklydocumentations%")
            ->get();
        foreach ($olds as $old) {
            // Remove the permission from roles and users
            $old->roles()->detach();
            $old->users()->detach();

            // Delete the permission
            $old->delete();
        }
    }
};
