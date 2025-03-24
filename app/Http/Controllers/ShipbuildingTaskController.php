<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShipbuildingTaskStoreRequest;
use App\Http\Requests\ShipbuildingTaskUpdateRequest;
use App\Lib\TaskType;
use App\Models\Shipbuilding;
use App\Models\ShipbuildingTask;
use fredyns\stringcleaner\StringCleaner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShipbuildingTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ShipbuildingTask::class);

        $search = (string)$request->get('search', '');

        if (!$search or $search == 'null') {
            $search = '';
        }

        $shipbuildingTasks = ShipbuildingTask::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.shipbuilding_tasks.index',
            compact('shipbuildingTasks', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ShipbuildingTask::class);

        $shipbuildings = Shipbuilding::pluck('name', 'id');
        $shipbuildingTasks = ShipbuildingTask::pluck('name', 'id');

        return view(
            'app.shipbuilding_tasks.create',
            compact('shipbuildings', 'shipbuildingTasks')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        ShipbuildingTaskStoreRequest $request
    ): RedirectResponse
    {
        $this->authorize('create', ShipbuildingTask::class);

        $validated = $request->validated();
        if (isset($validated['description'])) {
            $validated['description'] = StringCleaner::forRTF(
                $validated['description']
            );
        }

        $shipbuildingTask = ShipbuildingTask::create($validated);

        return redirect()
            ->route('shipbuilding-tasks.show', $shipbuildingTask)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request          $request,
        ShipbuildingTask $shipbuildingTask
    ): View
    {
        $this->authorize('view', $shipbuildingTask);

        if ($shipbuildingTask->enable_sub_progress == TaskType::CATEGORY) {
            $view = 'app.shipbuilding_tasks.show-category';
        } else if ($shipbuildingTask->enable_sub_progress == TaskType::WORK_ITEM) {
            $view = 'app.shipbuilding_tasks.show-worksheet';
        } else {
            $view = 'app.shipbuilding_tasks.show';
        }

        return view('app.shipbuilding_tasks.show', compact('shipbuildingTask'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request          $request,
        ShipbuildingTask $shipbuildingTask
    ): View
    {
        $this->authorize('update', $shipbuildingTask);

        $shipbuildings = Shipbuilding::pluck('name', 'id');
        $shipbuildingTasks = ShipbuildingTask::pluck('name', 'id');

        return view(
            'app.shipbuilding_tasks.edit',
            compact('shipbuildingTask', 'shipbuildings', 'shipbuildingTasks')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ShipbuildingTaskUpdateRequest $request,
        ShipbuildingTask              $shipbuildingTask
    ): RedirectResponse
    {
        $this->authorize('update', $shipbuildingTask);

        $validated = $request->validated();

        $validated['description'] = StringCleaner::forRTF(
            $validated['description']
        );

        $shipbuildingTask->update($validated);

        return redirect()
            ->route('shipbuilding-tasks.show', $shipbuildingTask)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request          $request,
        ShipbuildingTask $shipbuildingTask
    ): RedirectResponse
    {
        $this->authorize('delete', $shipbuildingTask);

        $shipbuildingTask->delete();

        return redirect()
            ->route('shipbuilding-tasks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
