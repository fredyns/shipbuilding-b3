<?php

namespace App\Http\Livewire;

use App\Models\DailyEquipment;
use App\Models\DailyReport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class DailyReportDailyEquipmentsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public DailyReport $dailyReport;
    public DailyEquipment $dailyEquipment;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModalView = false;
    public $showingModalForm = false;

    public $modalTitle = 'New DailyEquipment';

    protected $rules = [
        'dailyEquipment.name' => ['required', 'max:255', 'string'],
        'dailyEquipment.quantity' => ['required', 'numeric'],
        'dailyEquipment.remark' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(DailyReport $dailyReport): void
    {
        $this->dailyReport = $dailyReport;
        $this->resetDailyEquipmentData();
    }

    public function resetDailyEquipmentData(): void
    {
        $this->dailyEquipment = new DailyEquipment();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDailyEquipment(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.daily_report_equipments.new_title');
        $this->resetDailyEquipmentData();

        $this->showModalForm();
    }

    public function viewDailyEquipment(DailyEquipment $dailyEquipment): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.daily_report_equipments.show_title');
        $this->dailyEquipment = $dailyEquipment;

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editDailyEquipment(DailyEquipment $dailyEquipment): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.daily_report_equipments.edit_title');
        $this->dailyEquipment = $dailyEquipment;

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

        if (!$this->dailyEquipment->daily_report_id) {
            $this->authorize('create', DailyEquipment::class);

            $this->dailyEquipment->daily_report_id = $this->dailyReport->id;
        } else {
            $this->authorize('update', $this->dailyEquipment);
        }

        $this->dailyEquipment->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', DailyEquipment::class);

        DailyEquipment::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDailyEquipmentData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->dailyReport->dailyEquipments as $dailyEquipment) {
            array_push($this->selected, $dailyEquipment->id);
        }
    }

    public function render(): View
    {
        return view('livewire.daily-report-daily-equipments-detail', [
            'dailyEquipments' => $this->dailyReport
                ->dailyEquipments()
                ->paginate(100),
        ]);
    }
}
