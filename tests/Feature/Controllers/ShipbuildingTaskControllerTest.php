<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ShipbuildingTask;

use App\Models\Shipbuilding;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShipbuildingTaskControllerTest extends TestCase
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
    public function it_displays_index_view_with_shipbuilding_tasks(): void
    {
        $shipbuildingTasks = ShipbuildingTask::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('shipbuilding-tasks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.shipbuilding_tasks.index')
            ->assertViewHas('shipbuildingTasks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_shipbuilding_task(): void
    {
        $response = $this->get(route('shipbuilding-tasks.create'));

        $response->assertOk()->assertViewIs('app.shipbuilding_tasks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_shipbuilding_task(): void
    {
        $data = ShipbuildingTask::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('shipbuilding-tasks.store'), $data);

        unset($data['level']);
        unset($data['sort_order']);
        unset($data['lock_element_set']);
        unset($data['score']);
        unset($data['sub_tasks_count']);
        unset($data['sub_tasks_weight_sum']);
        unset($data['sub_tasks_score_sum']);
        unset($data['on_group_progress']);
        unset($data['on_project_weight']);
        unset($data['on_project_progress']);
        unset($data['metadata']);

        $this->assertDatabaseHas('shipbuilding_tasks', $data);

        $shipbuildingTask = ShipbuildingTask::latest('id')->first();

        $response->assertRedirect(
            route('shipbuilding-tasks.edit', $shipbuildingTask)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_shipbuilding_task(): void
    {
        $shipbuildingTask = ShipbuildingTask::factory()->create();

        $response = $this->get(
            route('shipbuilding-tasks.show', $shipbuildingTask)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.shipbuilding_tasks.show')
            ->assertViewHas('shipbuildingTask');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_shipbuilding_task(): void
    {
        $shipbuildingTask = ShipbuildingTask::factory()->create();

        $response = $this->get(
            route('shipbuilding-tasks.edit', $shipbuildingTask)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.shipbuilding_tasks.edit')
            ->assertViewHas('shipbuildingTask');
    }

    /**
     * @test
     */
    public function it_updates_the_shipbuilding_task(): void
    {
        $shipbuildingTask = ShipbuildingTask::factory()->create();

        $shipbuilding = Shipbuilding::factory()->create();
        $shipbuildingTask = ShipbuildingTask::factory()->create();

        $data = [
            'shipbuilding_id' => $this->faker->randomNumber(),
            'level' => $this->faker->randomNumber(),
            'sort_order' => $this->faker->randomNumber(0),
            'parent_task_id' => $this->faker->randomNumber(),
            'item_type' => 'work-item',
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'weight' => $this->faker->randomNumber(1),
            'enable_sub_progress' => 'none',
            'progress_options' => [],
            'sub_tasks_count' => $this->faker->randomNumber(0),
            'sub_tasks_weight_sum' => $this->faker->randomNumber(1),
            'metadata' => [],
            'shipbuilding_id' => $shipbuilding->id,
            'parent_task_id' => $shipbuildingTask->id,
        ];

        $response = $this->put(
            route('shipbuilding-tasks.update', $shipbuildingTask),
            $data
        );

        unset($data['level']);
        unset($data['sort_order']);
        unset($data['lock_element_set']);
        unset($data['score']);
        unset($data['sub_tasks_count']);
        unset($data['sub_tasks_weight_sum']);
        unset($data['sub_tasks_score_sum']);
        unset($data['on_group_progress']);
        unset($data['on_project_weight']);
        unset($data['on_project_progress']);
        unset($data['metadata']);

        $data['id'] = $shipbuildingTask->id;

        $this->assertDatabaseHas('shipbuilding_tasks', $data);

        $response->assertRedirect(
            route('shipbuilding-tasks.edit', $shipbuildingTask)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_shipbuilding_task(): void
    {
        $shipbuildingTask = ShipbuildingTask::factory()->create();

        $response = $this->delete(
            route('shipbuilding-tasks.destroy', $shipbuildingTask)
        );

        $response->assertRedirect(route('shipbuilding-tasks.index'));

        $this->assertModelMissing($shipbuildingTask);
    }
}
