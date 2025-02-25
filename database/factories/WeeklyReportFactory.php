<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\WeeklyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeeklyReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WeeklyReport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'week' => $this->faker->randomNumber(0),
            'month' => $this->faker->date(),
            'summary' => $this->faker->text(),
            'report_file' => $this->faker->text(),
            'metadata' => [],
            'shipbuilding_id' => \App\Models\Shipbuilding::factory(),
        ];
    }
}
