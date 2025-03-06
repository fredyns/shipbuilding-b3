<?php

namespace Database\Factories;

use App\Models\DailyActivity;
use App\Models\DailyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'pic' => $this->faker->text(255),
            'daily_report_id' => DailyReport::factory(),
        ];
    }
}
