<?php

namespace App\Http\Livewire;

use App\Models\ShipbuildingTask;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ShipbuildingTaskShipbuildingTasksDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public ShipbuildingTask $parentTask;
    public ShipbuildingTask $shipbuildingTask;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModalView = false;
    public $showingModalForm = false;

    public $modalTitle = 'New ShipbuildingTask';

    protected $rules = [
        'shipbuildingTask.name' => ['required', 'max:255', 'string'],
        'shipbuildingTask.description' => ['nullable', 'max:255', 'string'],
        'shipbuildingTask.weight' => ['required', 'numeric'],
        'shipbuildingTask.enable_sub_progress' => [
            'required',
            'in:none,category,work-item',
        ],
        'shipbuildingTask.progress' => ['required', 'numeric'],
        'shipbuildingTask.target' => ['required', 'numeric'],
        'shipbuildingTask.deviation' => ['required', 'numeric'],
    ];

    public function mount(ShipbuildingTask $parentTask): void
    {
        $this->parentTask = $parentTask;
        $this->resetShipbuildingTaskData();
    }

    public function resetShipbuildingTaskData(): void
    {
        $this->shipbuildingTask = new ShipbuildingTask();

        $this->shipbuildingTask->shipbuilding_id = $this->parentTask->shipbuilding_id;
        $this->shipbuildingTask->level = 1 + (int)optional($this->parentTask)->level;
        $this->shipbuildingTask->parent_task_id = $this->parentTask->id;
        $this->shipbuildingTask->item_type = 'work-item';
        $this->shipbuildingTask->enable_sub_progress = 'none';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newShipbuildingTask(): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.shipbuilding_task_shipbuilding_tasks.new_title'
        );
        $this->resetShipbuildingTaskData();

        $this->showModalForm();
    }

    public function viewShipbuildingTask(
        ShipbuildingTask $shipbuildingTask
    ): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.shipbuilding_task_shipbuilding_tasks.show_title'
        );
        $this->shipbuildingTask = $shipbuildingTask;

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editShipbuildingTask(
        ShipbuildingTask $shipbuildingTask
    ): void
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.shipbuilding_task_shipbuilding_tasks.edit_title'
        );
        $this->shipbuildingTask = $shipbuildingTask;

        $this->dispatchBrowserEvent('refresh');

        $this->showModalForm();
    }

    public function showModalView(): void
    {
        $this->resetErrorBag();
        $this->showingModalView = true;
        $this->showingModalForm = false;
    }

    public function showModalForm(): void
    {
        $this->resetErrorBag();
        $this->showingModalView = false;
        $this->showingModalForm = true;
    }

    public function hideModal(): void
    {
        $this->showingModalView = false;
        $this->showingModalForm = false;
    }

    public function save(): void
    {
        $this->validate();

        if (!$this->shipbuildingTask->parent_task_id) {
            $this->authorize('create', ShipbuildingTask::class);

            $this->shipbuildingTask->shipbuilding_id = $this->parentTask->shipbuilding_id;
            $this->shipbuildingTask->level = eval($this->parentTask->level) + 1;
            $this->shipbuildingTask->parent_task_id = $this->parentTask->id;
            $this->shipbuildingTask->item_type = 'work-item';
        } else {
            $this->authorize('update', $this->shipbuildingTask);
        }

        $this->shipbuildingTask->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', ShipbuildingTask::class);

        ShipbuildingTask::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetShipbuildingTaskData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->parentTask->shipbuildingTasks as $shipbuildingTask) {
            array_push($this->selected, $shipbuildingTask->id);
        }
    }

    public function render(): View
    {
        return view('livewire.shipbuilding-task-shipbuilding-tasks-detail', [
            'shipbuildingTasks' => $this->parentTask
                ->shipbuildingTasks()
                ->paginate(100),
        ]);
    }
}
