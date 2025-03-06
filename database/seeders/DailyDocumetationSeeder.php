<?php

namespace Database\Seeders;

use App\Models\DailyDocumetation;
use Illuminate\Database\Seeder;

class DailyDocumetationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyDocumetation::factory()
            ->count(5)
            ->create();
    }
}
