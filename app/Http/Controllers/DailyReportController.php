<?php

namespace App\Http\Controllers;

use App\Http\Requests\DailyReportStoreRequest;
use App\Http\Requests\DailyReportUpdateRequest;
use App\Models\DailyReport;
use App\Models\Humidity;
use App\Models\Shipbuilding;
use App\Models\Weather;
use fredyns\stringcleaner\StringCleaner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', DailyReport::class);

        $search = (string)$request->get('search', '');

        if (!$search or $search == 'null') {
            $search = '';
        }

        $dailyReports = DailyReport::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.daily_reports.index',
            compact('dailyReports', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', DailyReport::class);

        $shipbuildings = Shipbuilding::pluck('name', 'id');
        $weathers = Weather::pluck('name', 'id');
        $humidities = Humidity::pluck('name', 'id');

        return view(
            'app.daily_reports.create',
            compact(
                'shipbuildings',
                'weathers',
                'humidities',
                'weathers',
                'humidities',
                'weathers',
                'humidities'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DailyReportStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', DailyReport::class);

        $validated = $request->validated();
        if (isset($validated['summary'])) {
            $validated['summary'] = StringCleaner::forRTF(
                $validated['summary']
            );
        }

        $dailyReport = DailyReport::create($validated);

        return redirect()
            ->route('daily-reports.show', $dailyReport)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, DailyReport $dailyReport): View
    {
        $this->authorize('view', $dailyReport);

        return view('app.daily_reports.show', compact('dailyReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, DailyReport $dailyReport): View
    {
        $this->authorize('update', $dailyReport);

        $shipbuildings = Shipbuilding::pluck('name', 'id');
        $weathers = Weather::pluck('name', 'id');
        $humidities = Humidity::pluck('name', 'id');

        return view(
            'app.daily_reports.edit',
            compact(
                'dailyReport',
                'shipbuildings',
                'weathers',
                'humidities',
                'weathers',
                'humidities',
                'weathers',
                'humidities'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        DailyReportUpdateRequest $request,
        DailyReport              $dailyReport
    ): RedirectResponse
    {
        $this->authorize('update', $dailyReport);

        $validated = $request->validated();

        $validated['summary'] = StringCleaner::forRTF($validated['summary']);

        $dailyReport->update($validated);

        return redirect()
            ->route('daily-reports.show', $dailyReport)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request     $request,
        DailyReport $dailyReport
    ): RedirectResponse
    {
        $this->authorize('delete', $dailyReport);

        $dailyReport->delete();

        return redirect()
            ->route('daily-reports.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
