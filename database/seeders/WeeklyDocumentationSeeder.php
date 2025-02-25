<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WeeklyDocumentation;

class WeeklyDocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WeeklyDocumentation::factory()
            ->count(5)
            ->create();
    }
}
