<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\MonthlyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

class MonthlyReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MonthlyReport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'month' => $this->faker->date(),
            'planned_progress' => $this->faker->randomNumber(1),
            'actual_progres' => $this->faker->randomNumber(1),
            'report_file' => $this->faker->text(),
            'summary' => $this->faker->text(),
            'metadata' => [],
            'shipbuilding_id' => \App\Models\Shipbuilding::factory(),
        ];
    }
}
