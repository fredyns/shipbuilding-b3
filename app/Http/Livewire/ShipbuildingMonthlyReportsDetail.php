<?php

namespace App\Http\Livewire;

use App\Models\MonthlyReport;
use App\Models\Shipbuilding;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShipbuildingMonthlyReportsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Shipbuilding $shipbuilding;
    public MonthlyReport $monthlyReport;
    public $monthlyReportReportFile;
    public $uploadIteration = 0;
    public $monthlyReportMonth;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModalView = false;
    public $showingModalForm = false;

    public $modalTitle = 'New MonthlyReport';

    protected $rules = [
        'monthlyReportMonth' => ['required', 'date_format:Y-m'],
        'monthlyReport.planned_progress' => [
            'nullable',
            'numeric',
            'min:0',
            'max:100',
        ],
        'monthlyReport.actual_progres' => [
            'nullable',
            'numeric',
            'min:0',
            'max:100',
        ],
        'monthlyReportReportFile' => ['file', 'max:20500', 'nullable', 'extensions:pdf,docx,xlsx,pptx'],
        'monthlyReport.summary' => ['nullable', 'string'],
    ];

    public function mount(Shipbuilding $shipbuilding): void
    {
        $this->shipbuilding = $shipbuilding;
        $this->resetMonthlyReportData();
    }

    public function resetMonthlyReportData(): void
    {
        $this->monthlyReport = new MonthlyReport();

        $this->monthlyReportReportFile = null;
        $this->monthlyReportMonth = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newMonthlyReport(): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.shipbuilding_monthly_reports.new_title'
        );
        $this->resetMonthlyReportData();

        $this->showModalForm();
    }

    public function viewMonthlyReport(MonthlyReport $monthlyReport): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.shipbuilding_monthly_reports.show_title'
        );
        $this->monthlyReport = $monthlyReport;

        $this->monthlyReportMonth = optional(
            $this->monthlyReport->month
        )->format('Y-m');

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editMonthlyReport(MonthlyReport $monthlyReport): void
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.shipbuilding_monthly_reports.edit_title'
        );
        $this->monthlyReport = $monthlyReport;

        $this->monthlyReportMonth = optional(
            $this->monthlyReport->month
        )->format('Y-m');

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
        /**
         * 'email' => Rule::unique('users')->where(fn (Builder $query) => $query->where('account_id', 1))
         */
        $this->rules['monthlyReportMonth'] = [
            'required',
            'date_format:Y-m',
            function (string $attribute, mixed $value, \Closure $fail) {
                $exist = MonthlyReport::where('shipbuilding_id', $this->shipbuilding->id)
                    ->where('month', $value . '-01')
                    ->exists();

                if ($exist) {
                    $fail("Laporan pada bulan tersebut sudah ada, silahkan pilih bulan lainnya.");
                }
            },
        ];
        $this->validate();

        if (!$this->monthlyReport->shipbuilding_id) {
            $this->authorize('create', MonthlyReport::class);

            $this->monthlyReport->shipbuilding_id = $this->shipbuilding->id;
        } else {
            $this->authorize('update', $this->monthlyReport);
        }

        if ($this->monthlyReportReportFile) {
            $this->monthlyReport->report_file = $this->monthlyReportReportFile->store(
                'public'
            );
        }

        $this->monthlyReport->month = \Carbon\Carbon::make(
            $this->monthlyReportMonth
        );

        $this->monthlyReport->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', MonthlyReport::class);

        collect($this->selected)->each(function (string $id) {
            $monthlyReport = MonthlyReport::findOrFail($id);

            if ($monthlyReport->report_file) {
                Storage::delete($monthlyReport->report_file);
            }

            $monthlyReport->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetMonthlyReportData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->shipbuilding->monthlyReports as $monthlyReport) {
            array_push($this->selected, $monthlyReport->id);
        }
    }

    public function render(): View
    {
        return view('livewire.shipbuilding-monthly-reports-detail', [
            'monthlyReports' => $this->shipbuilding
                ->monthlyReports()
                ->paginate(100),
        ]);
    }
}
