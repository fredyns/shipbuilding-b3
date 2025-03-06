<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Weather;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
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
    public function it_displays_index_view_with_weathers(): void
    {
        $weathers = Weather::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('weathers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.weathers.index')
            ->assertViewHas('weathers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_weather(): void
    {
        $response = $this->get(route('weathers.create'));

        $response->assertOk()->assertViewIs('app.weathers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_weather(): void
    {
        $data = Weather::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('weathers.store'), $data);

        unset($data['metadata']);

        $this->assertDatabaseHas('weathers', $data);

        $weather = Weather::latest('id')->first();

        $response->assertRedirect(route('weathers.edit', $weather));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_weather(): void
    {
        $weather = Weather::factory()->create();

        $response = $this->get(route('weathers.show', $weather));

        $response
            ->assertOk()
            ->assertViewIs('app.weathers.show')
            ->assertViewHas('weather');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_weather(): void
    {
        $weather = Weather::factory()->create();

        $response = $this->get(route('weathers.edit', $weather));

        $response
            ->assertOk()
            ->assertViewIs('app.weathers.edit')
            ->assertViewHas('weather');
    }

    /**
     * @test
     */
    public function it_updates_the_weather(): void
    {
        $weather = Weather::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'metadata' => [],
        ];

        $response = $this->put(route('weathers.update', $weather), $data);

        unset($data['metadata']);

        $data['id'] = $weather->id;

        $this->assertDatabaseHas('weathers', $data);

        $response->assertRedirect(route('weathers.edit', $weather));
    }

    /**
     * @test
     */
    public function it_deletes_the_weather(): void
    {
        $weather = Weather::factory()->create();

        $response = $this->delete(route('weathers.destroy', $weather));

        $response->assertRedirect(route('weathers.index'));

        $this->assertModelMissing($weather);
    }
}
