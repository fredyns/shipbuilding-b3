<?php

namespace App\Http\Controllers;

use App\Models\ShipType;
use App\Models\Shipyard;
use Illuminate\View\View;
use App\Models\Shipbuilding;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use fredyns\stringcleaner\StringCleaner;
use App\Http\Requests\ShipbuildingStoreRequest;
use App\Http\Requests\ShipbuildingUpdateRequest;

class ShipbuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Shipbuilding::class);

        $search = (string) $request->get('search', '');

        if (!$search or $search == 'null') {
            $search = '';
        }

        $shipbuildings = Shipbuilding::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.shipbuildings.index',
            compact('shipbuildings', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Shipbuilding::class);

        $shipTypes = ShipType::pluck('name', 'id');
        $shipyards = Shipyard::pluck('name', 'id');

        return view(
            'app.shipbuildings.create',
            compact('shipTypes', 'shipyards')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShipbuildingStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Shipbuilding::class);

        $validated = $request->validated();
        $validated['description'] = StringCleaner::forRTF(
            $validated['description']
        );

        $uploadPath = 'public/shipbuildings/' . date('Y/m/d');
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store($uploadPath);
        }

        $shipbuilding = Shipbuilding::create($validated);

        return redirect()
            ->route('shipbuildings.show', $shipbuilding)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Shipbuilding $shipbuilding): View
    {
        $this->authorize('view', $shipbuilding);

        return view('app.shipbuildings.show', compact('shipbuilding'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Shipbuilding $shipbuilding): View
    {
        $this->authorize('update', $shipbuilding);

        $shipTypes = ShipType::pluck('name', 'id');
        $shipyards = Shipyard::pluck('name', 'id');

        return view(
            'app.shipbuildings.edit',
            compact('shipbuilding', 'shipTypes', 'shipyards')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ShipbuildingUpdateRequest $request,
        Shipbuilding $shipbuilding
    ): RedirectResponse {
        $this->authorize('update', $shipbuilding);

        $validated = $request->validated();

        $validated['description'] = StringCleaner::forRTF(
            $validated['description']
        );

        $uploadPath = 'public/shipbuildings/' . date('Y/m/d');
        if ($request->hasFile('cover_image')) {
            if ($shipbuilding->cover_image) {
                Storage::delete($shipbuilding->cover_image);
            }

            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store($uploadPath);
        }

        $shipbuilding->update($validated);

        return redirect()
            ->route('shipbuildings.show', $shipbuilding)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Shipbuilding $shipbuilding
    ): RedirectResponse {
        $this->authorize('delete', $shipbuilding);

        if ($shipbuilding->cover_image) {
            Storage::delete($shipbuilding->cover_image);
        }

        $shipbuilding->delete();

        return redirect()
            ->route('shipbuildings.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
