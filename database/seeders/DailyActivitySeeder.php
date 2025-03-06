<?php

namespace Database\Seeders;

use App\Models\DailyActivity;
use Illuminate\Database\Seeder;

class DailyActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyActivity::factory()
            ->count(5)
            ->create();
    }
}
