<?php

namespace Database\Factories;

use App\Models\Humidity;
use Illuminate\Database\Eloquent\Factories\Factory;

class HumidityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Humidity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'metadata' => [],
        ];
    }
}
