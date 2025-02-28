<?php

namespace App\Http\Livewire;

use App\Models\Shipbuilding;
use App\Models\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShipbuildingWeeklyReportsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Shipbuilding $shipbuilding;
    public WeeklyReport $weeklyReport;
    public $weeklyReportReportFile;
    public $uploadIteration = 0;
    public $weeklyReportDate;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModalView = false;
    public $showingModalForm = false;

    public $modalTitle = 'New WeeklyReport';

    protected $rules = [
        'weeklyReport.week' => ['required', 'numeric'],
        'weeklyReportDate' => ['nullable', 'date'],
        'weeklyReport.planned_progress' => ['nullable', 'numeric'],
        'weeklyReport.actual_progress' => ['nullable', 'numeric'],
        'weeklyReport.summary' => ['nullable', 'max:255', 'string'],
        'weeklyReportReportFile' => ['file', 'max:1024', 'nullable'],
    ];

    public function mount(Shipbuilding $shipbuilding): void
    {
        $this->shipbuilding = $shipbuilding;
        $this->resetWeeklyReportData();
    }

    public function resetWeeklyReportData(): void
    {
        $this->weeklyReport = new WeeklyReport();

        $this->weeklyReportReportFile = null;
        $this->weeklyReportDate = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newWeeklyReport(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.shipbuilding_weekly_reports.new_title');
        $this->resetWeeklyReportData();

        $this->showModalForm();
    }

    public function viewWeeklyReport(WeeklyReport $weeklyReport): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.shipbuilding_weekly_reports.show_title'
        );
        $this->weeklyReport = $weeklyReport;

        $this->weeklyReportDate = optional($this->weeklyReport->date)->format(
            'Y-m-d'
        );

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editWeeklyReport(WeeklyReport $weeklyReport): void
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.shipbuilding_weekly_reports.edit_title'
        );
        $this->weeklyReport = $weeklyReport;

        $this->weeklyReportDate = optional($this->weeklyReport->date)->format(
            'Y-m-d'
        );

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

        if (!$this->weeklyReport->shipbuilding_id) {
            $this->authorize('create', WeeklyReport::class);

            $this->weeklyReport->shipbuilding_id = $this->shipbuilding->id;
        } else {
            $this->authorize('update', $this->weeklyReport);
        }

        if ($this->weeklyReportReportFile) {
            $this->weeklyReport->report_file = $this->weeklyReportReportFile->store(
                'public'
            );
        }

        $this->weeklyReport->date = Carbon::make(
            $this->weeklyReportDate
        );

        $this->weeklyReport->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', WeeklyReport::class);

        collect($this->selected)->each(function (string $id) {
            $weeklyReport = WeeklyReport::findOrFail($id);

            if ($weeklyReport->report_file) {
                Storage::delete($weeklyReport->report_file);
            }

            $weeklyReport->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetWeeklyReportData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->shipbuilding->weeklyReports as $weeklyReport) {
            array_push($this->selected, $weeklyReport->id);
        }
    }

    public function render(): View
    {
        return view('livewire.shipbuilding-weekly-reports-detail', [
            'weeklyReports' => $this->shipbuilding
                ->weeklyReports()
                ->where('date', '<=', date('Y-m-d'))
                ->orderBy('date', 'desc')
                ->paginate(100),
        ]);
    }
}
