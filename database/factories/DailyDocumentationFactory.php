<?php

namespace Database\Factories;

use App\Models\DailyDocumentation;
use App\Models\DailyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyDocumentationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyDocumentation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => $this->faker->text(),
            'remark' => $this->faker->text(255),
            'daily_report_id' => DailyReport::factory(),
        ];
    }
}
