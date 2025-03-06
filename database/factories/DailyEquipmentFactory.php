<?php

namespace Database\Factories;

use App\Models\DailyEquipment;
use App\Models\DailyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyEquipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyEquipment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'quantity' => $this->faker->randomNumber(),
            'remark' => $this->faker->text(255),
            'daily_report_id' => DailyReport::factory(),
        ];
    }
}
