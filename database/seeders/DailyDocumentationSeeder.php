<?php

namespace Database\Seeders;

use App\Models\DailyDocumentation;
use Illuminate\Database\Seeder;

class DailyDocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyDocumentation::factory()
            ->count(5)
            ->create();
    }
}
