<?php

namespace App\Http\Livewire;

use App\Models\DailyReport;
use App\Models\Humidity;
use App\Models\Shipbuilding;
use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ShipbuildingDailyReportsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Shipbuilding $shipbuilding;
    public DailyReport $dailyReport;
    public $weathersForSelect = [];
    public $humiditiesForSelect = [];
    public $dailyReportDate;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModalView = false;
    public $showingModalForm = false;

    public $modalTitle = 'New DailyReport';

    protected $rules = [
        'dailyReportDate' => ['required', 'date'],
        'dailyReport.week' => ['required', 'numeric'],
        'dailyReport.actual_progress' => ['nullable', 'numeric'],
        'dailyReport.morning_weather_id' => ['nullable', 'exists:weathers,id'],
        'dailyReport.morning_humidity_id' => [
            'nullable',
            'exists:humidities,id',
        ],
        'dailyReport.midday_weather_id' => ['nullable', 'exists:weathers,id'],
        'dailyReport.midday_humidity_id' => [
            'nullable',
            'exists:humidities,id',
        ],
        'dailyReport.afternoon_weather_id' => [
            'nullable',
            'exists:weathers,id',
        ],
        'dailyReport.afternoon_humidity_id' => [
            'nullable',
            'exists:humidities,id',
        ],
        'dailyReport.temperature' => ['nullable', 'numeric'],
        'dailyReport.summary' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(Shipbuilding $shipbuilding): void
    {
        $this->shipbuilding = $shipbuilding;
        $this->weathersForSelect = Weather::pluck('name', 'id');
        $this->humiditiesForSelect = Humidity::pluck('name', 'id');
        $this->resetDailyReportData();
    }

    public function resetDailyReportData(): void
    {
        $this->dailyReport = new DailyReport();

        $this->dailyReportDate = null;
        $this->dailyReport->morning_weather_id = null;
        $this->dailyReport->morning_humidity_id = null;
        $this->dailyReport->midday_weather_id = null;
        $this->dailyReport->midday_humidity_id = null;
        $this->dailyReport->afternoon_weather_id = null;
        $this->dailyReport->afternoon_humidity_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDailyReport(): void
    {
        $this->dispatchBrowserEvent(
            'redirect',
            ['url' => route('daily-reports.create', ['shipbuilding_id' => $this->shipbuilding->id])]
        );
    }

    public function viewDailyReport(DailyReport $dailyReport): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.shipbuilding_daily_reports.show_title');
        $this->dailyReport = $dailyReport;

        $this->dailyReportDate = optional($this->dailyReport->date)->format(
            'Y-m-d'
        );

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editDailyReport(DailyReport $dailyReport): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.shipbuilding_daily_reports.edit_title');
        $this->dailyReport = $dailyReport;

        $this->dailyReportDate = optional($this->dailyReport->date)->format(
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

        if (!$this->dailyReport->shipbuilding_id) {
            $this->authorize('create', DailyReport::class);

            $this->dailyReport->shipbuilding_id = $this->shipbuilding->id;
        } else {
            $this->authorize('update', $this->dailyReport);
        }

        $this->dailyReport->date = Carbon::make($this->dailyReportDate);
        $this->dailyReport->week = $this->dailyReport->weekDifference();

        $this->dailyReport->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', DailyReport::class);

        DailyReport::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDailyReportData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->shipbuilding->dailyReports as $dailyReport) {
            array_push($this->selected, $dailyReport->id);
        }
    }

    public function render(): View
    {
        return view('livewire.shipbuilding-daily-reports-detail', [
            'dailyReports' => $this->shipbuilding
                ->dailyReports()
                ->orderBy('date', 'desc')
                ->with([
                    'morningWeather', 'middayWeather', 'afternoonWeather',
                    'morningHumidity', 'middayHumidity', 'afternoonHumidity',
                ])
                ->paginate(10),
        ]);
    }
}
