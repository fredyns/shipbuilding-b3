<?php

namespace Database\Seeders;

use App\Models\DailyPersonnel;
use Illuminate\Database\Seeder;

class DailyPersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyPersonnel::factory()
            ->count(5)
            ->create();
    }
}
