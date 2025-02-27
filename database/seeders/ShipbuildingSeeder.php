<?php

namespace Database\Seeders;

use App\Models\Shipbuilding;
use App\Models\ShipType;
use Illuminate\Database\Seeder;

class ShipbuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tugBoat = ShipType::firstOrCreate(['name' => 'Tug Boat']);
        $barge = ShipType::firstOrCreate(['name' => 'Barge']);
        Shipbuilding::insert([
            [
                'number' => "H-1889",
                'name' => "Tug Boat 1889",
                'start_date' => "2025-01-20",
                'ship_type_id' => $tugBoat->id,
            ],
            [
                'number' => "H-1890",
                'name' => "Tug Boat 1890",
                'start_date' => "2025-01-22",
                'ship_type_id' => $tugBoat->id,
            ],
            [
                'number' => "H-1894",
                'name' => "Tug Boat 1894",
                'start_date' => "2025-02-15",
                'ship_type_id' => $tugBoat->id,
            ],
            [
                'number' => "H-1895",
                'name' => "Tug Boat 1895",
                'start_date' => "2025-02-15",
                'ship_type_id' => $tugBoat->id,
            ],
            [
                'number' => "H-2020",
                'name' => "Barge 2020 - 300 FT",
                'start_date' => "2025-02-08",
                'ship_type_id' => $barge->id,
            ],
            [
                'number' => "H-2021",
                'name' => "Barge 2021 - 300 FT",
                'start_date' => "2025-02-08",
                'ship_type_id' => $barge->id,
            ],
            [
                'number' => "H-2022",
                'name' => "Barge 2022 - 330 FT",
                'start_date' => "2025-02-08",
                'ship_type_id' => $barge->id,
            ],
            [
                'number' => "H-2023",
                'name' => "Barge 2023 - 330 FT",
                'start_date' => "2025-02-08",
                'ship_type_id' => $barge->id,
            ],
        ]);
    }
}
