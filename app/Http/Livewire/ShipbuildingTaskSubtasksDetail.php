<?php

namespace App\Http\Livewire;

use App\Lib\TaskParents;
use App\Models\ShipbuildingTask;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ShipbuildingTaskSubtasksDetail extends Component
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

    public $parentOptions = [];

    protected $rules = [
        'shipbuildingTask.parent_task_id' => ['nullable'],
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

        $parental = new TaskParents($this->parentTask);
        $this->parentOptions = $parental->getOptions();

        $this->rules['shipbuildingTask.parent_task_id'] = [
            'nullable',
            'exists:shipbuilding_tasks,id',
            'in:' . implode(',', array_values($this->parentOptions)),
        ];
    }

    public function resetShipbuildingTaskData(): void
    {
        $this->shipbuildingTask = new ShipbuildingTask();

        $this->shipbuildingTask->shipbuilding_id = $this->parentTask->shipbuilding_id;
        $this->shipbuildingTask->level = 1 + (int)optional($this->parentTask)->level;
        $this->shipbuildingTask->parent_task_id = null;
        $this->shipbuildingTask->item_type = 'work-item';
        $this->shipbuildingTask->enable_sub_progress = 'none';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newShipbuildingTask(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.subtasks.new_title');
        $this->resetShipbuildingTaskData();

        $this->showModalForm();
    }

    public function viewShipbuildingTask(ShipbuildingTask $shipbuildingTask): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.subtasks.show_title');
        $this->shipbuildingTask = $shipbuildingTask;

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editShipbuildingTask(ShipbuildingTask $shipbuildingTask): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.subtasks.edit_title');
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

            $this->shipbuildingTask->shipbuilding_id = $this->parentTask->shipbuilding_id;
        } else {
            $this->authorize('update', $this->shipbuildingTask);
        }

        $parent = ShipbuildingTask::find($this->shipbuildingTask->parent_task_id);
        if ($parent) {
            $this->shipbuildingTask->level = $parent->level + 1;
            $this->shipbuildingTask->item_type = $parent->enable_sub_progress;
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
        return view('livewire.shipbuilding-task-subtasks-detail', [
            'shipbuildingTasks' => $this->parentTask
                ->shipbuildingTasks()
                ->paginate(1000),
        ]);
    }
}
