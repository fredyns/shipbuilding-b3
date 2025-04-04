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
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(DailyActivitySeeder::class);
        $this->call(DailyDocumentationSeeder::class);
        $this->call(DailyEquipmentSeeder::class);
        $this->call(DailyMaterialSeeder::class);
        $this->call(DailyPersonnelSeeder::class);
        $this->call(DailyReportSeeder::class);
        $this->call(HumiditySeeder::class);
        $this->call(MonthlyReportSeeder::class);
        $this->call(ShipbuildingSeeder::class);
        $this->call(ShipbuildingTaskSeeder::class);
        $this->call(ShipTypeSeeder::class);
        $this->call(ShipyardSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(WeatherSeeder::class);
        $this->call(WeeklyDocumentationSeeder::class);
        $this->call(WeeklyReportSeeder::class);
    }
}
