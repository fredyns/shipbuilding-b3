<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\Shipbuilding;
use App\Models\ShipbuildingTask;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShipbuildingShipbuildingTasksDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Shipbuilding $shipbuilding;
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
        'shipbuildingTask.progress_options' => ['nullable', 'max:255', 'json'],
        'shipbuildingTask.progress' => ['required', 'numeric'],
        'shipbuildingTask.target' => ['required', 'numeric'],
        'shipbuildingTask.deviation' => ['required', 'numeric'],
    ];

    public function mount(Shipbuilding $shipbuilding): void
    {
        $this->shipbuilding = $shipbuilding;
        $this->resetShipbuildingTaskData();
    }

    public function resetShipbuildingTaskData(): void
    {
        $this->shipbuildingTask = new ShipbuildingTask();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newShipbuildingTask(): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.shipbuilding_shipbuilding_tasks.new_title'
        );
        $this->resetShipbuildingTaskData();

        $this->showModalForm();
    }

    public function viewShipbuildingTask(
        ShipbuildingTask $shipbuildingTask
    ): void {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.shipbuilding_shipbuilding_tasks.show_title'
        );
        $this->shipbuildingTask = $shipbuildingTask;

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editShipbuildingTask(
        ShipbuildingTask $shipbuildingTask
    ): void {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.shipbuilding_shipbuilding_tasks.edit_title'
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

        if (!$this->shipbuildingTask->shipbuilding_id) {
            $this->authorize('create', ShipbuildingTask::class);

            $this->shipbuildingTask->shipbuilding_id = $this->shipbuilding->id;
        } else {
            $this->authorize('update', $this->shipbuildingTask);
        }

        $this->shipbuildingTask->progress_options = json_decode(
            $this->shipbuildingTask->progress_options,
            true
        );

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

        foreach ($this->shipbuilding->shipbuildingTasks as $shipbuildingTask) {
            array_push($this->selected, $shipbuildingTask->id);
        }
    }

    public function render(): View
    {
        return view('livewire.shipbuilding-shipbuilding-tasks-detail', [
            'shipbuildingTasks' => $this->shipbuilding->breakdownTasks(),
        ]);
    }
}
