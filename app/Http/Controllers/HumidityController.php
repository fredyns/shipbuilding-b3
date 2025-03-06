<?php

namespace App\Http\Controllers;

use App\Http\Requests\HumidityStoreRequest;
use App\Http\Requests\HumidityUpdateRequest;
use App\Models\Humidity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HumidityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Humidity::class);

        $search = (string)$request->get('search', '');

        if (!$search or $search == 'null') {
            $search = '';
        }

        $humidities = Humidity::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.humidities.index', compact('humidities', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Humidity::class);

        return view('app.humidities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HumidityStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Humidity::class);

        $validated = $request->validated();

        $humidity = Humidity::create($validated);

        return redirect()
            ->route('humidities.show', $humidity)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Humidity $humidity): View
    {
        $this->authorize('view', $humidity);

        return view('app.humidities.show', compact('humidity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Humidity $humidity): View
    {
        $this->authorize('update', $humidity);

        return view('app.humidities.edit', compact('humidity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        HumidityUpdateRequest $request,
        Humidity              $humidity
    ): RedirectResponse
    {
        $this->authorize('update', $humidity);

        $validated = $request->validated();

        $humidity->update($validated);

        return redirect()
            ->route('humidities.show', $humidity)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request  $request,
        Humidity $humidity
    ): RedirectResponse
    {
        $this->authorize('delete', $humidity);

        $humidity->delete();

        return redirect()
            ->route('humidities.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
