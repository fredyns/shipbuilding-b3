<?php

namespace App\Http\Livewire;

use App\Models\DailyDocumetation;
use App\Models\DailyReport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DailyReportDailyDocumetationsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public DailyReport $dailyReport;
    public DailyDocumetation $dailyDocumetation;
    public $dailyDocumetationImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModalView = false;
    public $showingModalForm = false;

    public $modalTitle = 'New DailyDocumetation';

    protected $rules = [
        'dailyDocumetationImage' => ['image', 'max:1024', 'required'],
        'dailyDocumetation.remark' => ['required', 'max:255', 'string'],
    ];

    public function mount(DailyReport $dailyReport): void
    {
        $this->dailyReport = $dailyReport;
        $this->resetDailyDocumetationData();
    }

    public function resetDailyDocumetationData(): void
    {
        $this->dailyDocumetation = new DailyDocumetation();

        $this->dailyDocumetationImage = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDailyDocumetation(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.daily_report_documetations.new_title');
        $this->resetDailyDocumetationData();

        $this->showModalForm();
    }

    public function viewDailyDocumetation(
        DailyDocumetation $dailyDocumetation
    ): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.daily_report_documetations.show_title');
        $this->dailyDocumetation = $dailyDocumetation;

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editDailyDocumetation(
        DailyDocumetation $dailyDocumetation
    ): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.daily_report_documetations.edit_title');
        $this->dailyDocumetation = $dailyDocumetation;

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

        if (!$this->dailyDocumetation->daily_report_id) {
            $this->authorize('create', DailyDocumetation::class);

            $this->dailyDocumetation->daily_report_id = $this->dailyReport->id;
        } else {
            $this->authorize('update', $this->dailyDocumetation);
        }

        if ($this->dailyDocumetationImage) {
            $this->dailyDocumetation->image = $this->dailyDocumetationImage->store(
                'public'
            );
        }

        $this->dailyDocumetation->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', DailyDocumetation::class);

        collect($this->selected)->each(function (string $id) {
            $dailyDocumetation = DailyDocumetation::findOrFail($id);

            if ($dailyDocumetation->image) {
                Storage::delete($dailyDocumetation->image);
            }

            $dailyDocumetation->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDailyDocumetationData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->dailyReport->dailyDocumetations as $dailyDocumetation) {
            array_push($this->selected, $dailyDocumetation->id);
        }
    }

    public function render(): View
    {
        return view('livewire.daily-report-daily-documetations-detail', [
            'dailyDocumetations' => $this->dailyReport
                ->dailyDocumetations()
                ->paginate(100),
        ]);
    }
}
