<?php

namespace Database\Seeders;

use App\Models\ShipType;
use Illuminate\Database\Seeder;

class ShipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShipType::factory()
            ->count(5)
            ->create();
    }
}
