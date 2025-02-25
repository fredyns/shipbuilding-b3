<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShipyardStoreRequest;
use App\Http\Requests\ShipyardUpdateRequest;
use App\Models\Shipyard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShipyardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Shipyard::class);

        $search = (string)$request->get('search', '');

        if (!$search or $search == 'null') {
            $search = '';
        }

        $shipyards = Shipyard::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.shipyards.index', compact('shipyards', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Shipyard::class);

        return view('app.shipyards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShipyardStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Shipyard::class);

        $validated = $request->validated();

        $shipyard = Shipyard::create($validated);

        return redirect()
            ->route('shipyards.show', $shipyard)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Shipyard $shipyard): View
    {
        $this->authorize('view', $shipyard);

        return view('app.shipyards.show', compact('shipyard'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Shipyard $shipyard): View
    {
        $this->authorize('update', $shipyard);

        return view('app.shipyards.edit', compact('shipyard'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ShipyardUpdateRequest $request,
        Shipyard              $shipyard
    ): RedirectResponse
    {
        $this->authorize('update', $shipyard);

        $validated = $request->validated();

        $shipyard->update($validated);

        return redirect()
            ->route('shipyards.show', $shipyard)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request  $request,
        Shipyard $shipyard
    ): RedirectResponse
    {
        $this->authorize('delete', $shipyard);

        $shipyard->delete();

        return redirect()
            ->route('shipyards.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
