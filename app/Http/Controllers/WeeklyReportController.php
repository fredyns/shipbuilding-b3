<?php

namespace App\Http\Controllers;

use App\Helpers\Date;
use App\Http\Requests\WeeklyReportStoreRequest;
use App\Http\Requests\WeeklyReportUpdateRequest;
use App\Models\Shipbuilding;
use App\Models\WeeklyReport;
use Carbon\Carbon;
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
        $weeklyReport = new WeeklyReport([
            'shipbuilding_id' => $request->get('shipbuilding_id', 0),
            'week' => $request->get('week', 0),
            'planned_progress' => $request->get('planned_progress'),
            'actual_progress' => $request->get('actual_progress'),
        ]);

        $lastReport = $this->adjustNewReport($weeklyReport);

        return view('app.weekly_reports.create', compact('shipbuildings', 'weeklyReport', 'lastReport'));
    }

    protected function adjustNewReport(WeeklyReport &$weeklyReport)
    {
        if ($weeklyReport->shipbuilding_id < 1) return;

        $shipbuilding = Shipbuilding::findOrFail($weeklyReport->shipbuilding_id);
        $lastReport = $shipbuilding->weeklyReports()->orderBy('week', 'desc')->first();
        if ($lastReport) {
            $weeklyReport->week = $lastReport->week + 1;
            $weeklyReport->date = $lastReport->date->addWeeks(1);
            $weeklyReport->planned_progress = $lastReport->planned_progress;
        } else {
            $weeklyReport->week = 0;
            $weeklyReport->date = $shipbuilding->start_date;
        }

        return $lastReport;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WeeklyReportStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', WeeklyReport::class);

        $validated = $request->validated();

        /* @var $shipbuilding Shipbuilding */
        $shipbuilding = Shipbuilding::findOrFail($validated['shipbuilding_id']);
        if ($shipbuilding->start_date && $validated['date']) {
            $weekDiff = Date::weekDiff($shipbuilding->start_date, $validated['date']);
            if ($weekDiff != $validated['week']) {
                $date = new Carbon($validated['date']);
//                return redirect()->back()
//                    ->withErrors(['week' => "Tanggal {$date->format('d M Y')} harusnya minggu ke-{$weekDiff}"])
//                    ->withInput();
            }
        } else if ($shipbuilding->start_date) {
            $date = new Carbon($shipbuilding->start_date);
            $date->addWeeks($validated['week']);
            $validated['date'] = $date->format('Y-m-d');
        }

        if (isset($validated['summary'])) {
            $validated['summary'] = StringCleaner::forRTF(
                $validated['summary']
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

        /* @var $shipbuilding Shipbuilding */
        $shipbuilding = Shipbuilding::findOrFail($validated['shipbuilding_id']);
        if ($shipbuilding->start_date && $validated['date']) {
            $weekDiff = Date::weekDiff($shipbuilding->start_date, $validated['date']);
            if ($weekDiff != $validated['week']) {
                $date = new Carbon($validated['date']);
//                return redirect()->back()
//                    ->withErrors(['week' => "Tanggal {$date->format('d M Y')} harusnya minggu ke-{$weekDiff}"])
//                    ->withInput();
            }
        } else if ($shipbuilding->start_date) {
            $date = new Carbon($shipbuilding->start_date);
            $date->addWeeks($validated['week']);
            $validated['date'] = $date->format('Y-m-d');
        }

        $validated['summary'] = StringCleaner::forRTF($validated['summary']);

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
