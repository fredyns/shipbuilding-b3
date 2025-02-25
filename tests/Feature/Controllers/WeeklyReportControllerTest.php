<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\WeeklyReport;

use App\Models\Shipbuilding;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeeklyReportControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_weekly_reports(): void
    {
        $weeklyReports = WeeklyReport::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('weekly-reports.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.weekly_reports.index')
            ->assertViewHas('weeklyReports');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_weekly_report(): void
    {
        $response = $this->get(route('weekly-reports.create'));

        $response->assertOk()->assertViewIs('app.weekly_reports.create');
    }

    /**
     * @test
     */
    public function it_stores_the_weekly_report(): void
    {
        $data = WeeklyReport::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('weekly-reports.store'), $data);

        unset($data['metadata']);

        $this->assertDatabaseHas('weekly_reports', $data);

        $weeklyReport = WeeklyReport::latest('id')->first();

        $response->assertRedirect(route('weekly-reports.edit', $weeklyReport));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_weekly_report(): void
    {
        $weeklyReport = WeeklyReport::factory()->create();

        $response = $this->get(route('weekly-reports.show', $weeklyReport));

        $response
            ->assertOk()
            ->assertViewIs('app.weekly_reports.show')
            ->assertViewHas('weeklyReport');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_weekly_report(): void
    {
        $weeklyReport = WeeklyReport::factory()->create();

        $response = $this->get(route('weekly-reports.edit', $weeklyReport));

        $response
            ->assertOk()
            ->assertViewIs('app.weekly_reports.edit')
            ->assertViewHas('weeklyReport');
    }

    /**
     * @test
     */
    public function it_updates_the_weekly_report(): void
    {
        $weeklyReport = WeeklyReport::factory()->create();

        $shipbuilding = Shipbuilding::factory()->create();

        $data = [
            'shipbuilding_id' => $this->faker->randomNumber(),
            'week' => $this->faker->randomNumber(0),
            'month' => $this->faker->date(),
            'summary' => $this->faker->text(),
            'report_file' => $this->faker->text(),
            'metadata' => [],
            'shipbuilding_id' => $shipbuilding->id,
        ];

        $response = $this->put(
            route('weekly-reports.update', $weeklyReport),
            $data
        );

        unset($data['metadata']);

        $data['id'] = $weeklyReport->id;

        $this->assertDatabaseHas('weekly_reports', $data);

        $response->assertRedirect(route('weekly-reports.edit', $weeklyReport));
    }

    /**
     * @test
     */
    public function it_deletes_the_weekly_report(): void
    {
        $weeklyReport = WeeklyReport::factory()->create();

        $response = $this->delete(
            route('weekly-reports.destroy', $weeklyReport)
        );

        $response->assertRedirect(route('weekly-reports.index'));

        $this->assertModelMissing($weeklyReport);
    }
}
