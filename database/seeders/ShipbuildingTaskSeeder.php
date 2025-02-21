<?php

namespace Database\Seeders;

use App\Models\Shipbuilding;
use App\Models\ShipbuildingTask;
use Illuminate\Database\Seeder;

class ShipbuildingTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tugData = include __DIR__ . '/data/ShipbuildingTaskSeeder.php';

        if (!is_array($tugData)) {
            $this->command->warn('ShipbuildingTaskSeeder empty.');
            return;
        }

        $lastID = (int)ShipbuildingTask::max('id');
        $shipbuildings = Shipbuilding::all();
        foreach ($shipbuildings as $shipbuilding) {
            $taskSeeds = $this->adjustID($tugData, $shipbuilding, $lastID);
            ShipbuildingTask::insert($taskSeeds);

            $lastID += count($taskSeeds);
        }
    }

    protected function adjustID($taskSeeds, Shipbuilding $shipbuilding, $lastID)
    {
        foreach ($taskSeeds as &$taskSeed) {
            $taskSeed['id'] += $lastID;
            $taskSeed['shipbuilding_id'] = $shipbuilding->id;

            if ($taskSeed['parent_task_id'] > 0) {
                $taskSeed['parent_task_id'] += $lastID;
            }
        }

        return $taskSeeds;
    }
}
