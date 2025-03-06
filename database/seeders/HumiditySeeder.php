<?php

namespace Database\Seeders;

use App\Models\Humidity;
use Illuminate\Database\Seeder;

class HumiditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Humidity::factory()
            ->count(5)
            ->create();
    }
}
