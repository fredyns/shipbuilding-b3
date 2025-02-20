<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Shipbuilding;

use App\Models\ShipType;
use App\Models\Shipyard;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShipbuildingControllerTest extends TestCase
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
    public function it_displays_index_view_with_shipbuildings(): void
    {
        $shipbuildings = Shipbuilding::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('shipbuildings.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.shipbuildings.index')
            ->assertViewHas('shipbuildings');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_shipbuilding(): void
    {
        $response = $this->get(route('shipbuildings.create'));

        $response->assertOk()->assertViewIs('app.shipbuildings.create');
    }

    /**
     * @test
     */
    public function it_stores_the_shipbuilding(): void
    {
        $data = Shipbuilding::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('shipbuildings.store'), $data);

        unset($data['tasks_level_deep']);
        unset($data['tasks_count']);
        unset($data['tasks_weight_sum']);
        unset($data['tasks_score_sum']);
        unset($data['target']);

        $this->assertDatabaseHas('shipbuildings', $data);

        $shipbuilding = Shipbuilding::latest('id')->first();

        $response->assertRedirect(route('shipbuildings.edit', $shipbuilding));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_shipbuilding(): void
    {
        $shipbuilding = Shipbuilding::factory()->create();

        $response = $this->get(route('shipbuildings.show', $shipbuilding));

        $response
            ->assertOk()
            ->assertViewIs('app.shipbuildings.show')
            ->assertViewHas('shipbuilding');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_shipbuilding(): void
    {
        $shipbuilding = Shipbuilding::factory()->create();

        $response = $this->get(route('shipbuildings.edit', $shipbuilding));

        $response
            ->assertOk()
            ->assertViewIs('app.shipbuildings.edit')
            ->assertViewHas('shipbuilding');
    }

    /**
     * @test
     */
    public function it_updates_the_shipbuilding(): void
    {
        $shipbuilding = Shipbuilding::factory()->create();

        $shipType = ShipType::factory()->create();
        $shipyard = Shipyard::factory()->create();

        $data = [
            'number' => $this->faker->text(255),
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'progress' => $this->faker->randomNumber(1),
            'ship_type_id' => $this->faker->randomNumber(),
            'shipyard_id' => $this->faker->randomNumber(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'tasks_count' => $this->faker->randomNumber(0),
            'tasks_weight_sum' => $this->faker->randomNumber(1),
            'ship_type_id' => $shipType->id,
            'shipyard_id' => $shipyard->id,
        ];

        $response = $this->put(
            route('shipbuildings.update', $shipbuilding),
            $data
        );

        unset($data['tasks_level_deep']);
        unset($data['tasks_count']);
        unset($data['tasks_weight_sum']);
        unset($data['tasks_score_sum']);
        unset($data['target']);

        $data['id'] = $shipbuilding->id;

        $this->assertDatabaseHas('shipbuildings', $data);

        $response->assertRedirect(route('shipbuildings.edit', $shipbuilding));
    }

    /**
     * @test
     */
    public function it_deletes_the_shipbuilding(): void
    {
        $shipbuilding = Shipbuilding::factory()->create();

        $response = $this->delete(
            route('shipbuildings.destroy', $shipbuilding)
        );

        $response->assertRedirect(route('shipbuildings.index'));

        $this->assertModelMissing($shipbuilding);
    }
}
