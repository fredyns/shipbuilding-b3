<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Shipyard;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShipyardControllerTest extends TestCase
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
    public function it_displays_index_view_with_shipyards(): void
    {
        $shipyards = Shipyard::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('shipyards.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.shipyards.index')
            ->assertViewHas('shipyards');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_shipyard(): void
    {
        $response = $this->get(route('shipyards.create'));

        $response->assertOk()->assertViewIs('app.shipyards.create');
    }

    /**
     * @test
     */
    public function it_stores_the_shipyard(): void
    {
        $data = Shipyard::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('shipyards.store'), $data);

        $this->assertDatabaseHas('shipyards', $data);

        $shipyard = Shipyard::latest('id')->first();

        $response->assertRedirect(route('shipyards.edit', $shipyard));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_shipyard(): void
    {
        $shipyard = Shipyard::factory()->create();

        $response = $this->get(route('shipyards.show', $shipyard));

        $response
            ->assertOk()
            ->assertViewIs('app.shipyards.show')
            ->assertViewHas('shipyard');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_shipyard(): void
    {
        $shipyard = Shipyard::factory()->create();

        $response = $this->get(route('shipyards.edit', $shipyard));

        $response
            ->assertOk()
            ->assertViewIs('app.shipyards.edit')
            ->assertViewHas('shipyard');
    }

    /**
     * @test
     */
    public function it_updates_the_shipyard(): void
    {
        $shipyard = Shipyard::factory()->create();

        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->put(route('shipyards.update', $shipyard), $data);

        $data['id'] = $shipyard->id;

        $this->assertDatabaseHas('shipyards', $data);

        $response->assertRedirect(route('shipyards.edit', $shipyard));
    }

    /**
     * @test
     */
    public function it_deletes_the_shipyard(): void
    {
        $shipyard = Shipyard::factory()->create();

        $response = $this->delete(route('shipyards.destroy', $shipyard));

        $response->assertRedirect(route('shipyards.index'));

        $this->assertModelMissing($shipyard);
    }
}
