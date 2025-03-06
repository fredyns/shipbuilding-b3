<?php

namespace Tests\Feature\Controllers;

use App\Models\DailyReport;
use App\Models\Humidity;
use App\Models\Shipbuilding;
use App\Models\User;
use App\Models\Weather;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DailyReportControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_daily_reports(): void
    {
        $dailyReports = DailyReport::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('daily-reports.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.daily_reports.index')
            ->assertViewHas('dailyReports');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_daily_report(): void
    {
        $response = $this->get(route('daily-reports.create'));

        $response->assertOk()->assertViewIs('app.daily_reports.create');
    }

    /**
     * @test
     */
    public function it_stores_the_daily_report(): void
    {
        $data = DailyReport::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('daily-reports.store'), $data);

        unset($data['metadata']);

        $this->assertDatabaseHas('daily_reports', $data);

        $dailyReport = DailyReport::latest('id')->first();

        $response->assertRedirect(route('daily-reports.edit', $dailyReport));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_daily_report(): void
    {
        $dailyReport = DailyReport::factory()->create();

        $response = $this->get(route('daily-reports.show', $dailyReport));

        $response
            ->assertOk()
            ->assertViewIs('app.daily_reports.show')
            ->assertViewHas('dailyReport');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_daily_report(): void
    {
        $dailyReport = DailyReport::factory()->create();

        $response = $this->get(route('daily-reports.edit', $dailyReport));

        $response
            ->assertOk()
            ->assertViewIs('app.daily_reports.edit')
            ->assertViewHas('dailyReport');
    }

    /**
     * @test
     */
    public function it_updates_the_daily_report(): void
    {
        $dailyReport = DailyReport::factory()->create();

        $shipbuilding = Shipbuilding::factory()->create();
        $weather = Weather::factory()->create();
        $weather = Weather::factory()->create();
        $weather = Weather::factory()->create();
        $humidity = Humidity::factory()->create();
        $humidity = Humidity::factory()->create();
        $humidity = Humidity::factory()->create();

        $data = [
            'shipbuilding_id' => $this->faker->randomNumber(),
            'date' => $this->faker->date(),
            'week' => $this->faker->randomNumber(0),
            'actual_progress' => $this->faker->randomNumber(1),
            'morning_weather_id' => $this->faker->randomNumber(),
            'morning_humidity_id' => $this->faker->randomNumber(),
            'midday_weather_id' => $this->faker->randomNumber(),
            'midday_humidity_id' => $this->faker->randomNumber(),
            'afternoon_weather_id' => $this->faker->randomNumber(),
            'afternoon_humidity_id' => $this->faker->randomNumber(),
            'temperature' => $this->faker->randomNumber(0),
            'summary' => $this->faker->text(),
            'metadata' => [],
            'shipbuilding_id' => $shipbuilding->id,
            'morning_weather_id' => $weather->id,
            'midday_weather_id' => $weather->id,
            'afternoon_weather_id' => $weather->id,
            'morning_humidity_id' => $humidity->id,
            'midday_humidity_id' => $humidity->id,
            'afternoon_humidity_id' => $humidity->id,
        ];

        $response = $this->put(
            route('daily-reports.update', $dailyReport),
            $data
        );

        unset($data['metadata']);

        $data['id'] = $dailyReport->id;

        $this->assertDatabaseHas('daily_reports', $data);

        $response->assertRedirect(route('daily-reports.edit', $dailyReport));
    }

    /**
     * @test
     */
    public function it_deletes_the_daily_report(): void
    {
        $dailyReport = DailyReport::factory()->create();

        $response = $this->delete(route('daily-reports.destroy', $dailyReport));

        $response->assertRedirect(route('daily-reports.index'));

        $this->assertModelMissing($dailyReport);
    }
}
