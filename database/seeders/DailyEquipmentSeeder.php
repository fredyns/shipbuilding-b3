<?php

namespace Database\Seeders;

use App\Models\DailyEquipment;
use Illuminate\Database\Seeder;

class DailyEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyEquipment::factory()
            ->count(5)
            ->create();
    }
}
