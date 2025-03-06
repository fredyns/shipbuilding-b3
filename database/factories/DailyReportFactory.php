<?php

namespace Database\Factories;

use App\Models\DailyReport;
use App\Models\Humidity;
use App\Models\Shipbuilding;
use App\Models\Weather;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyReport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'week' => $this->faker->randomNumber(0),
            'actual_progress' => $this->faker->randomNumber(1),
            'temperature' => $this->faker->randomNumber(0),
            'summary' => $this->faker->text(),
            'metadata' => [],
            'shipbuilding_id' => Shipbuilding::factory(),
            'morning_weather_id' => Weather::factory(),
            'midday_weather_id' => Weather::factory(),
            'afternoon_weather_id' => Weather::factory(),
            'morning_humidity_id' => Humidity::factory(),
            'midday_humidity_id' => Humidity::factory(),
            'afternoon_humidity_id' => Humidity::factory(),
        ];
    }
}
