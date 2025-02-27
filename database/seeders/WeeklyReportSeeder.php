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
        $keywords = [
            //tug boats
            '1889', '1890', '1894', '1895',
            //barge
            '2020', '2021', '2022', '2023',
        ];
        foreach ($keywords as $keyword) {
            $this->execute($keyword);
        }
    }

    public function execute($keyword): void
    {
        $data = include __DIR__ . "/WeeklyReport/{$keyword}.php";

        if (!is_array($data)) {
            $this->command->warn("WeeklyReport/{$keyword} not found.");
            return;
        }

        $ships = Shipbuilding::where('name', 'ilike', "%{$keyword}%")->get();

        foreach ($ships as $ship) {
            $this->prepareWeeklyReport($ship, $data);
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
