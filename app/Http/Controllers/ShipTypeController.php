<?php

namespace App\Http\Controllers;

use App\Models\ShipType;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use fredyns\stringcleaner\StringCleaner;
use App\Http\Requests\ShipTypeStoreRequest;
use App\Http\Requests\ShipTypeUpdateRequest;

class ShipTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ShipType::class);

        $search = (string) $request->get('search', '');

        if (!$search or $search == 'null') {
            $search = '';
        }

        $shipTypes = ShipType::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.ship_types.index', compact('shipTypes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ShipType::class);

        return view('app.ship_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShipTypeStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', ShipType::class);

        $validated = $request->validated();

        $shipType = ShipType::create($validated);

        return redirect()
            ->route('ship-types.show', $shipType)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ShipType $shipType): View
    {
        $this->authorize('view', $shipType);

        return view('app.ship_types.show', compact('shipType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ShipType $shipType): View
    {
        $this->authorize('update', $shipType);

        return view('app.ship_types.edit', compact('shipType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ShipTypeUpdateRequest $request,
        ShipType $shipType
    ): RedirectResponse {
        $this->authorize('update', $shipType);

        $validated = $request->validated();

        $shipType->update($validated);

        return redirect()
            ->route('ship-types.show', $shipType)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ShipType $shipType
    ): RedirectResponse {
        $this->authorize('delete', $shipType);

        $shipType->delete();

        return redirect()
            ->route('ship-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
