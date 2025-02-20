<?php

namespace Database\Seeders;

use App\Models\Shipyard;
use Illuminate\Database\Seeder;

class ShipyardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shipyard::factory()
            ->count(5)
            ->create();
    }
}
