<?php

namespace Database\Seeders;

use App\Models\DailyReport;
use Illuminate\Database\Seeder;

class DailyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyReport::factory()
            ->count(5)
            ->create();
    }
}
