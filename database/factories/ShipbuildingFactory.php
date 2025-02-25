<?php

namespace Database\Factories;

use App\Models\Shipbuilding;
use App\Models\ShipType;
use App\Models\Shipyard;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipbuildingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shipbuilding::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->text(255),
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'progress' => $this->faker->randomNumber(1),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'tasks_count' => $this->faker->randomNumber(0),
            'tasks_weight_sum' => $this->faker->randomNumber(1),
            'ship_type_id' => ShipType::factory(),
            'shipyard_id' => Shipyard::factory(),
        ];
    }
}
