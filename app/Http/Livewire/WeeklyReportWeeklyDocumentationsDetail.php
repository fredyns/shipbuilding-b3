<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\WeeklyReport;
use Livewire\WithFileUploads;
use App\Models\WeeklyDocumentation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WeeklyReportWeeklyDocumentationsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public WeeklyReport $weeklyReport;
    public WeeklyDocumentation $weeklyDocumentation;
    public $weeklyDocumentationFile;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModalView = false;
    public $showingModalForm = false;

    public $modalTitle = 'New WeeklyDocumentation';

    protected $rules = [
        'weeklyDocumentationFile' => ['file', 'max:1024', 'required'],
        'weeklyDocumentation.name' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(WeeklyReport $weeklyReport): void
    {
        $this->weeklyReport = $weeklyReport;
        $this->resetWeeklyDocumentationData();
    }

    public function resetWeeklyDocumentationData(): void
    {
        $this->weeklyDocumentation = new WeeklyDocumentation();

        $this->weeklyDocumentationFile = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newWeeklyDocumentation(): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.weekly_report_documentations.new_title'
        );
        $this->resetWeeklyDocumentationData();

        $this->showModalForm();
    }

    public function viewWeeklyDocumentation(
        WeeklyDocumentation $weeklyDocumentation
    ): void {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.weekly_report_documentations.show_title'
        );
        $this->weeklyDocumentation = $weeklyDocumentation;

        $this->dispatchBrowserEvent('refresh');

        $this->showModalView();
    }

    public function editWeeklyDocumentation(
        WeeklyDocumentation $weeklyDocumentation
    ): void {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.weekly_report_documentations.edit_title'
        );
        $this->weeklyDocumentation = $weeklyDocumentation;

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

        if (!$this->weeklyDocumentation->weekly_report_id) {
            $this->authorize('create', WeeklyDocumentation::class);

            $this->weeklyDocumentation->weekly_report_id =
                $this->weeklyReport->id;
        } else {
            $this->authorize('update', $this->weeklyDocumentation);
        }

        if ($this->weeklyDocumentationFile) {
            $this->weeklyDocumentation->file = $this->weeklyDocumentationFile->store(
                'public'
            );
        }

        $this->weeklyDocumentation->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', WeeklyDocumentation::class);

        collect($this->selected)->each(function (string $id) {
            $weeklyDocumentation = WeeklyDocumentation::findOrFail($id);

            if ($weeklyDocumentation->file) {
                Storage::delete($weeklyDocumentation->file);
            }

            $weeklyDocumentation->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetWeeklyDocumentationData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->weeklyReport->weeklyDocumentations
            as $weeklyDocumentation
        ) {
            array_push($this->selected, $weeklyDocumentation->id);
        }
    }

    public function render(): View
    {
        return view('livewire.weekly-report-weekly-documentations-detail', [
            'weeklyDocumentations' => $this->weeklyReport
                ->weeklyDocumentations()
                ->paginate(100),
        ]);
    }
}
