<?php

namespace Database\Seeders;

use App\Models\MonthlyReport;
use Illuminate\Database\Seeder;

class MonthlyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MonthlyReport::factory()
            ->count(5)
            ->create();
    }
}
