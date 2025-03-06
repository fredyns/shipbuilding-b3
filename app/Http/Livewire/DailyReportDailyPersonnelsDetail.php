<?php

namespace App\Http\Livewire;

use App\Models\DailyPersonnel;
use App\Models\DailyReport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class DailyReportDailyPersonnelsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public DailyReport $dailyReport;
    public DailyPersonnel $dailyPersonnel;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModalView = false;
    public $showingModalForm = false;

    public $modalTitle = 'New DailyPersonnel';

    protected $rules = [
        'dailyPersonnel.role' => ['required', 'max:255', 'string'],
        'dailyPersonnel.present' => ['nullable', 'boolean'],
        'dailyPersonnel.description' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(DailyReport $dailyReport): void
    {
        $this->dailyReport = $dailyReport;
        $this->resetDailyPersonnelData();
    }

    public function resetDailyPersonnelData(): void
    {
        $this->dailyPersonnel = new DailyPersonnel();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDailyPersonnel(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.daily_report_personnels.new_title');
        $this->resetDailyPersonnelData();

        $this->showModalForm();
    }

    public function viewDailyPersonnel(DailyPersonnel $dailyPersonnel): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.daily_report_personnels.show_title');
        $this->dailyPersonnel = $dailyPersonnel;

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editDailyPersonnel(DailyPersonnel $dailyPersonnel): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.daily_report_personnels.edit_title');
        $this->dailyPersonnel = $dailyPersonnel;

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

        if (!$this->dailyPersonnel->daily_report_id) {
            $this->authorize('create', DailyPersonnel::class);

            $this->dailyPersonnel->daily_report_id = $this->dailyReport->id;
        } else {
            $this->authorize('update', $this->dailyPersonnel);
        }

        $this->dailyPersonnel->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', DailyPersonnel::class);

        DailyPersonnel::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDailyPersonnelData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->dailyReport->dailyPersonnels as $dailyPersonnel) {
            array_push($this->selected, $dailyPersonnel->id);
        }
    }

    public function render(): View
    {
        return view('livewire.daily-report-daily-personnels-detail', [
            'dailyPersonnels' => $this->dailyReport
                ->dailyPersonnels()
                ->paginate(100),
        ]);
    }
}
