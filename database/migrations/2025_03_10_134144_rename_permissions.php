<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permissions = Permission::where('name', 'like', '%dailydocumetations%')->get();
        foreach ($permissions as $permission) {
            $permission->name = str_replace('dailydocumetations', 'dailydocumentations', $permission->name);
            $permission->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissions = Permission::where('name', 'like', '%dailydocumentations%')->get();
        foreach ($permissions as $permission) {
            $permission->name = str_replace('dailydocumentations', 'dailydocumetations', $permission->name);
            $permission->save();
        }
    }
};
