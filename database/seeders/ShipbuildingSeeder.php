<?php

namespace Database\Seeders;

use App\Models\Shipbuilding;
use Illuminate\Database\Seeder;

class ShipbuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shipbuilding::factory()
            ->count(5)
            ->create();
    }
}
