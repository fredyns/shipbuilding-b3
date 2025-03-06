<?php

namespace Database\Seeders;

use App\Models\DailyMaterial;
use Illuminate\Database\Seeder;

class DailyMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyMaterial::factory()
            ->count(5)
            ->create();
    }
}
