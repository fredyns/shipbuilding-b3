<?php

namespace App\Http\Livewire;

use App\Models\DailyMaterial;
use App\Models\DailyReport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class DailyReportDailyMaterialsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public DailyReport $dailyReport;
    public DailyMaterial $dailyMaterial;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModalView = false;
    public $showingModalForm = false;

    public $modalTitle = 'New DailyMaterial';

    protected $rules = [
        'dailyMaterial.name' => ['required', 'max:255', 'string'],
        'dailyMaterial.quantity' => ['required', 'numeric'],
        'dailyMaterial.remark' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(DailyReport $dailyReport): void
    {
        $this->dailyReport = $dailyReport;
        $this->resetDailyMaterialData();
    }

    public function resetDailyMaterialData(): void
    {
        $this->dailyMaterial = new DailyMaterial();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDailyMaterial(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.daily_report_materials.new_title');
        $this->resetDailyMaterialData();

        $this->showModalForm();
    }

    public function viewDailyMaterial(DailyMaterial $dailyMaterial): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.daily_report_materials.show_title');
        $this->dailyMaterial = $dailyMaterial;

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editDailyMaterial(DailyMaterial $dailyMaterial): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.daily_report_materials.edit_title');
        $this->dailyMaterial = $dailyMaterial;

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

        if (!$this->dailyMaterial->daily_report_id) {
            $this->authorize('create', DailyMaterial::class);

            $this->dailyMaterial->daily_report_id = $this->dailyReport->id;
        } else {
            $this->authorize('update', $this->dailyMaterial);
        }

        $this->dailyMaterial->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', DailyMaterial::class);

        DailyMaterial::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDailyMaterialData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->dailyReport->dailyMaterials as $dailyMaterial) {
            array_push($this->selected, $dailyMaterial->id);
        }
    }

    public function render(): View
    {
        return view('livewire.daily-report-daily-materials-detail', [
            'dailyMaterials' => $this->dailyReport
                ->dailyMaterials()
                ->paginate(100),
        ]);
    }
}
