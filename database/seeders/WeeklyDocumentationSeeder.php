<?php

namespace Database\Seeders;

use App\Models\WeeklyDocumentation;
use Illuminate\Database\Seeder;

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
