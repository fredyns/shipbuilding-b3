<?php

namespace App\Http\Livewire;

use App\Models\DailyDocumentation;
use App\Models\DailyReport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DailyReportDailyDocumentationsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public DailyReport $dailyReport;
    public DailyDocumentation $dailyDocumentation;
    public $dailyDocumentationImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModalView = false;
    public $showingModalForm = false;

    public $modalTitle = 'New DailyDocumentation';

    protected $rules = [
        'dailyDocumentationImage' => ['image', 'max:1024', 'required'],
        'dailyDocumentation.remark' => ['required', 'max:255', 'string'],
    ];

    public function mount(DailyReport $dailyReport): void
    {
        $this->dailyReport = $dailyReport;
        $this->resetDailyDocumentationData();
    }

    public function resetDailyDocumentationData(): void
    {
        $this->dailyDocumentation = new DailyDocumentation();

        $this->dailyDocumentationImage = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDailyDocumentation(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.daily_report_documentations.new_title');
        $this->resetDailyDocumentationData();

        $this->showModalForm();
    }

    public function viewDailyDocumentation(
        DailyDocumentation $dailyDocumentation
    ): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.daily_report_documentations.show_title'
        );
        $this->dailyDocumentation = $dailyDocumentation;

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editDailyDocumentation(
        DailyDocumentation $dailyDocumentation
    ): void
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.daily_report_documentations.edit_title'
        );
        $this->dailyDocumentation = $dailyDocumentation;

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

        if (!$this->dailyDocumentation->daily_report_id) {
            $this->authorize('create', DailyDocumentation::class);

            $this->dailyDocumentation->daily_report_id = $this->dailyReport->id;
        } else {
            $this->authorize('update', $this->dailyDocumentation);
        }

        if ($this->dailyDocumentationImage) {
            // todo: set upload path
            $this->dailyDocumentation->image = $this->dailyDocumentationImage->store(
                'public'
            );
        }

        $this->dailyDocumentation->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', DailyDocumentation::class);

        collect($this->selected)->each(function (string $id) {
            $dailyDocumentation = DailyDocumentation::findOrFail($id);

            if ($dailyDocumentation->image) {
                Storage::delete($dailyDocumentation->image);
            }

            $dailyDocumentation->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDailyDocumentationData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->dailyReport->dailyDocumentations
            as $dailyDocumentation
        ) {
            array_push($this->selected, $dailyDocumentation->id);
        }
    }

    public function render(): View
    {
        return view('livewire.daily-report-daily-documentations-detail', [
            'dailyDocumentations' => $this->dailyReport
                ->dailyDocumentations()
                ->paginate(100),
        ]);
    }
}
