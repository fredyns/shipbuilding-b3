<?php

namespace Database\Seeders;

use App\Models\WeeklyReport;
use Illuminate\Database\Seeder;

class WeeklyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WeeklyReport::factory()
            ->count(5)
            ->create();
    }
}
