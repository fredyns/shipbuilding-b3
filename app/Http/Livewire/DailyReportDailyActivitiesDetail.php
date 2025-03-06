<?php

namespace App\Http\Livewire;

use App\Models\DailyActivity;
use App\Models\DailyReport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class DailyReportDailyActivitiesDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public DailyReport $dailyReport;
    public DailyActivity $dailyActivity;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModalView = false;
    public $showingModalForm = false;

    public $modalTitle = 'New DailyActivity';

    protected $rules = [
        'dailyActivity.name' => ['required', 'max:255', 'string'],
        'dailyActivity.pic' => ['required', 'max:255', 'string'],
    ];

    public function mount(DailyReport $dailyReport): void
    {
        $this->dailyReport = $dailyReport;
        $this->resetDailyActivityData();
    }

    public function resetDailyActivityData(): void
    {
        $this->dailyActivity = new DailyActivity();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDailyActivity(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.daily_report_activities.new_title');
        $this->resetDailyActivityData();

        $this->showModalForm();
    }

    public function viewDailyActivity(DailyActivity $dailyActivity): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.daily_report_activities.show_title');
        $this->dailyActivity = $dailyActivity;

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editDailyActivity(DailyActivity $dailyActivity): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.daily_report_activities.edit_title');
        $this->dailyActivity = $dailyActivity;

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

        if (!$this->dailyActivity->daily_report_id) {
            $this->authorize('create', DailyActivity::class);

            $this->dailyActivity->daily_report_id = $this->dailyReport->id;
        } else {
            $this->authorize('update', $this->dailyActivity);
        }

        $this->dailyActivity->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', DailyActivity::class);

        DailyActivity::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDailyActivityData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->dailyReport->dailyActivities as $dailyActivity) {
            array_push($this->selected, $dailyActivity->id);
        }
    }

    public function render(): View
    {
        return view('livewire.daily-report-daily-activities-detail', [
            'dailyActivities' => $this->dailyReport
                ->dailyActivities()
                ->paginate(100),
        ]);
    }
}
