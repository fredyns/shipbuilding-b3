<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeeklyReportStoreRequest;
use App\Http\Requests\WeeklyReportUpdateRequest;
use App\Models\Shipbuilding;
use App\Models\WeeklyReport;
use fredyns\stringcleaner\StringCleaner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WeeklyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', WeeklyReport::class);

        $search = (string)$request->get('search', '');

        if (!$search or $search == 'null') {
            $search = '';
        }

        $weeklyReports = WeeklyReport::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.weekly_reports.index',
            compact('weeklyReports', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', WeeklyReport::class);

        $shipbuildings = Shipbuilding::pluck('name', 'id');

        return view('app.weekly_reports.create', compact('shipbuildings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WeeklyReportStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', WeeklyReport::class);

        $validated = $request->validated();
        if (isset($validated['summary'])) {
            $validated['summary'] = StringCleaner::forRTF(
                $validated['summary']
            );
        }
        if (isset($validated['report_file'])) {
            $validated['report_file'] = StringCleaner::forRTF(
                $validated['report_file']
            );
        }

        $uploadPath = 'public/weekly-reports/' . date('Y/m/d');
        if ($request->hasFile('report_file')) {
            $validated['report_file'] = $request
                ->file('report_file')
                ->store($uploadPath);
        }

        /* @var $weeklyReport WeeklyReport */
        $weeklyReport = WeeklyReport::create($validated);

        $weeklyReport->topupProgress();

        return redirect()
            ->route('weekly-reports.show', $weeklyReport)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, WeeklyReport $weeklyReport): View
    {
        $this->authorize('view', $weeklyReport);

        return view('app.weekly_reports.show', compact('weeklyReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, WeeklyReport $weeklyReport): View
    {
        $this->authorize('update', $weeklyReport);

        $shipbuildings = Shipbuilding::pluck('name', 'id');

        return view(
            'app.weekly_reports.edit',
            compact('weeklyReport', 'shipbuildings')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        WeeklyReportUpdateRequest $request,
        WeeklyReport              $weeklyReport
    ): RedirectResponse
    {
        $this->authorize('update', $weeklyReport);

        $validated = $request->validated();

        $validated['summary'] = StringCleaner::forRTF($validated['summary']);
        $validated['report_file'] = StringCleaner::forRTF(
            $validated['report_file']
        );

        $uploadPath = 'public/weekly-reports/' . date('Y/m/d');
        if ($request->hasFile('report_file')) {
            if ($weeklyReport->report_file) {
                Storage::delete($weeklyReport->report_file);
            }

            $validated['report_file'] = $request
                ->file('report_file')
                ->store($uploadPath);
        }

        $weeklyReport->update($validated);
        $weeklyReport->topupProgress();

        return redirect()
            ->route('weekly-reports.show', $weeklyReport)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request      $request,
        WeeklyReport $weeklyReport
    ): RedirectResponse
    {
        $this->authorize('delete', $weeklyReport);

        if ($weeklyReport->report_file) {
            Storage::delete($weeklyReport->report_file);
        }

        $weeklyReport->delete();

        return redirect()
            ->route('weekly-reports.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
