<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\WeeklyDocumentation;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeeklyDocumentationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WeeklyDocumentation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file' => $this->faker->text(),
            'name' => $this->faker->name(),
            'type' => $this->faker->text(255),
            'metadata' => [],
            'thumbnail' => $this->faker->text(),
            'weekly_report_id' => \App\Models\WeeklyReport::factory(),
        ];
    }
}
