<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ShipType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShipTypeControllerTest extends TestCase
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
    public function it_displays_index_view_with_ship_types(): void
    {
        $shipTypes = ShipType::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('ship-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.ship_types.index')
            ->assertViewHas('shipTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_ship_type(): void
    {
        $response = $this->get(route('ship-types.create'));

        $response->assertOk()->assertViewIs('app.ship_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_ship_type(): void
    {
        $data = ShipType::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('ship-types.store'), $data);

        $this->assertDatabaseHas('ship_types', $data);

        $shipType = ShipType::latest('id')->first();

        $response->assertRedirect(route('ship-types.edit', $shipType));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_ship_type(): void
    {
        $shipType = ShipType::factory()->create();

        $response = $this->get(route('ship-types.show', $shipType));

        $response
            ->assertOk()
            ->assertViewIs('app.ship_types.show')
            ->assertViewHas('shipType');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_ship_type(): void
    {
        $shipType = ShipType::factory()->create();

        $response = $this->get(route('ship-types.edit', $shipType));

        $response
            ->assertOk()
            ->assertViewIs('app.ship_types.edit')
            ->assertViewHas('shipType');
    }

    /**
     * @test
     */
    public function it_updates_the_ship_type(): void
    {
        $shipType = ShipType::factory()->create();

        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->put(route('ship-types.update', $shipType), $data);

        $data['id'] = $shipType->id;

        $this->assertDatabaseHas('ship_types', $data);

        $response->assertRedirect(route('ship-types.edit', $shipType));
    }

    /**
     * @test
     */
    public function it_deletes_the_ship_type(): void
    {
        $shipType = ShipType::factory()->create();

        $response = $this->delete(route('ship-types.destroy', $shipType));

        $response->assertRedirect(route('ship-types.index'));

        $this->assertModelMissing($shipType);
    }
}
