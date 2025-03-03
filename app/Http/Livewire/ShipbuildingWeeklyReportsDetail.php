<?php

namespace App\Http\Livewire;

use App\Models\Shipbuilding;
use App\Models\WeeklyReport;
use Carbon\Carbon;
use DateTime;
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

    public bool $adminMode = false;
    public bool $allWeek = false;

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

    public function mount(Shipbuilding $shipbuilding, $allWeek = false): void
    {
        $this->shipbuilding = $shipbuilding;
        $this->allWeek = (bool)$allWeek;
        $this->adminMode = auth()->user()->hasRole('super-admin');
        $this->resetWeeklyReportData();
    }

    public function resetWeeklyReportData(): void
    {
        $this->weeklyReport = new WeeklyReport();

        $this->weeklyReport->week = 0;
        $this->weeklyReport->date = date('Y-m-d');
        $this->weeklyReportReportFile = null;
        $this->weeklyReportDate = new DateTime();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newWeeklyReport(): void
    {
        if (!$this->adminMode) {
            $this->dispatchBrowserEvent('livewire-alert', ['message' => 'Fitur terkunci / tidak tersedia.']);
            return;
        }

        $this->editing = false;
        $this->modalTitle = trans('crud.shipbuilding_weekly_reports.new_title');
        $this->resetWeeklyReportData();
        $this->adjustWeek();

        $this->showModalForm();
    }

    protected function adjustWeek(): void
    {
        $last = $this->shipbuilding->weeklyReports()->orderBy('week', 'desc')->first();
        if ($last) {
            $this->weeklyReport->week = $last->week + 1;

            if ($last->date) {
                $this->weeklyReport->date = $last->date->add('7 days')->format('Y-m-d');
            }
        } else if ($this->shipbuilding->start_date) {
            $this->weeklyReport->date = $this->shipbuilding->start_date->format('Y-m-d');
        }
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
            'weeklyReports' => $this->reportsQuery(),
        ]);
    }

    public function reportsQuery()
    {
        $perPage = $this->allWeek ? 10000 : 5;
        $query = $this->shipbuilding
            ->weeklyReports()
            ->orderBy('week', 'desc');

        if (!$this->adminMode) {
            $query->where('date', '<=', date('Y-m-d'));
        }

        return $query->paginate($perPage);
    }
}
