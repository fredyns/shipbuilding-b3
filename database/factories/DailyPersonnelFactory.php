<?php

namespace Database\Factories;

use App\Models\DailyPersonnel;
use App\Models\DailyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyPersonnelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyPersonnel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role' => $this->faker->text(255),
            'present' => $this->faker->boolean(),
            'description' => $this->faker->text(255),
            'daily_report_id' => DailyReport::factory(),
        ];
    }
}
