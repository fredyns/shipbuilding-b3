<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeatherStoreRequest;
use App\Http\Requests\WeatherUpdateRequest;
use App\Models\Weather;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Weather::class);

        $search = (string)$request->get('search', '');

        if (!$search or $search == 'null') {
            $search = '';
        }

        $weathers = Weather::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.weathers.index', compact('weathers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Weather::class);

        return view('app.weathers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WeatherStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Weather::class);

        $validated = $request->validated();

        $weather = Weather::create($validated);

        return redirect()
            ->route('weathers.show', $weather)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Weather $weather): View
    {
        $this->authorize('view', $weather);

        return view('app.weathers.show', compact('weather'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Weather $weather): View
    {
        $this->authorize('update', $weather);

        return view('app.weathers.edit', compact('weather'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        WeatherUpdateRequest $request,
        Weather              $weather
    ): RedirectResponse
    {
        $this->authorize('update', $weather);

        $validated = $request->validated();

        $weather->update($validated);

        return redirect()
            ->route('weathers.show', $weather)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Weather $weather
    ): RedirectResponse
    {
        $this->authorize('delete', $weather);

        $weather->delete();

        return redirect()
            ->route('weathers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
