<?php

namespace Database\Seeders;

use App\Models\Shipbuilding;
use App\Models\WeeklyReport;
use Illuminate\Database\Seeder;

class WeeklyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tugData = include __DIR__ . '/data/TugWeeklyReportSeeder.php';

        if (!is_array($tugData)) {
            $this->command->warn('TugWeeklyReportSeeder empty.');
            return;
        }

        $tugboats = Shipbuilding::where('name', 'like', '%Tug%')->get();

        foreach ($tugboats as $tugboat) {
            $this->prepareWeeklyReport($tugboat, $tugData);
        }

    }

    protected function prepareWeeklyReport(Shipbuilding $shipbuilding, array $data): void
    {
        foreach ($data as &$row) {
            $row['shipbuilding_id'] = $shipbuilding->id;
        }

        WeeklyReport::insert($data);
    }
}
