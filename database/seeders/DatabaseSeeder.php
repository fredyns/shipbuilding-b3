<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // system

        $this->call(PermissionsSeeder::class);
        $this->call(UserSeeder::class);

        // master tables

        $this->call(ShipTypeSeeder::class);
        $this->call(ShipyardSeeder::class);

        // activities

        $this->call(ShipbuildingSeeder::class);
        $this->call(ShipbuildingTaskSeeder::class);
    }
}
