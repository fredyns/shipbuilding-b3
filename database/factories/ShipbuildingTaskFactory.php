<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ShipbuildingTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipbuildingTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipbuildingTask::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'level' => $this->faker->randomNumber(),
            'sort_order' => $this->faker->randomNumber(0),
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'weight' => $this->faker->randomNumber(1),
            'progress_options' => [],
            'sub_tasks_count' => $this->faker->randomNumber(0),
            'sub_tasks_weight_sum' => $this->faker->randomNumber(1),
            'metadata' => [],
            'shipbuilding_id' => \App\Models\Shipbuilding::factory(),
            'parent_task_id' => function () {
                return \App\Models\ShipbuildingTask::factory()->create([
                    'parent_task_id' => null,
                ])->id;
            },
        ];
    }
}
