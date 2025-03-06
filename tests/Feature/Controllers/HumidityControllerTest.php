<?php

namespace Tests\Feature\Controllers;

use App\Models\Humidity;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HumidityControllerTest extends TestCase
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
    public function it_displays_index_view_with_humidities(): void
    {
        $humidities = Humidity::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('humidities.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.humidities.index')
            ->assertViewHas('humidities');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_humidity(): void
    {
        $response = $this->get(route('humidities.create'));

        $response->assertOk()->assertViewIs('app.humidities.create');
    }

    /**
     * @test
     */
    public function it_stores_the_humidity(): void
    {
        $data = Humidity::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('humidities.store'), $data);

        unset($data['metadata']);

        $this->assertDatabaseHas('humidities', $data);

        $humidity = Humidity::latest('id')->first();

        $response->assertRedirect(route('humidities.edit', $humidity));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_humidity(): void
    {
        $humidity = Humidity::factory()->create();

        $response = $this->get(route('humidities.show', $humidity));

        $response
            ->assertOk()
            ->assertViewIs('app.humidities.show')
            ->assertViewHas('humidity');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_humidity(): void
    {
        $humidity = Humidity::factory()->create();

        $response = $this->get(route('humidities.edit', $humidity));

        $response
            ->assertOk()
            ->assertViewIs('app.humidities.edit')
            ->assertViewHas('humidity');
    }

    /**
     * @test
     */
    public function it_updates_the_humidity(): void
    {
        $humidity = Humidity::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'metadata' => [],
        ];

        $response = $this->put(route('humidities.update', $humidity), $data);

        unset($data['metadata']);

        $data['id'] = $humidity->id;

        $this->assertDatabaseHas('humidities', $data);

        $response->assertRedirect(route('humidities.edit', $humidity));
    }

    /**
     * @test
     */
    public function it_deletes_the_humidity(): void
    {
        $humidity = Humidity::factory()->create();

        $response = $this->delete(route('humidities.destroy', $humidity));

        $response->assertRedirect(route('humidities.index'));

        $this->assertModelMissing($humidity);
    }
}
