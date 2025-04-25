<?php

namespace App\Http\Controllers;

use App\Actions\DailyReport\DocxTemplate;
use App\Helpers\Date;
use App\Http\Requests\DailyReportStoreRequest;
use App\Http\Requests\DailyReportUpdateRequest;
use App\Models\DailyReport;
use App\Models\Humidity;
use App\Models\Shipbuilding;
use App\Models\Weather;
use Carbon\Carbon;
use fredyns\stringcleaner\StringCleaner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DailyReportController extends Controller
{
    public function docx(Request $request, DailyReport $dailyReport)
    {
        $this->authorize('view', $dailyReport);

        $docx = (new DocxTemplate($dailyReport))->run();
        $filename = "Laporan Harian {$dailyReport->shipbuilding->name} - "
            . $dailyReport->date->format('Y-m-d') . ".docx";

        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');

        $docx->saveAs("php://output");
    }

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

        // related data
        $shipbuildingID = request('shipbuilding_id');
        if (!is_numeric($shipbuildingID) or $shipbuildingID <= 0) {
            return redirect()
                ->route('dashboard')
                ->withError("Shipbuilding ID is not valid.");
        }

        $shipbuilding = Shipbuilding::where('id', $shipbuildingID)->firstOrFail();
        $lastReport = $shipbuilding->dailyReports()->orderBy('date', 'desc')->first();

        /**
         * IDE PENGEMBANGAN:
         *  - lihat laporan harian untuk tanggal sekarang ($today)
         *      - trus mau diedit atau nambah laporan di tanggal setelahnya?
         *  - lihat laporan mingguan di periode sebelumnya
         *      - default progres bisa start dr situ
         *  - konek ke API cuaca google atau opensource lainnya untuk isian default
         */

        // generate new data
        $today = new Carbon();
        $week = Date::weekDiff($shipbuilding->start_date, $today);
        $dailyReport = new DailyReport([
            'shipbuilding_id' => $shipbuildingID,
            'week' => $week,
            'actual_progress' => optional($lastReport)->actual_progress ?? 0,
            'temperature' => 27,
        ]);
        $dailyReport->date = $today;

        // form options
        $weathers = Weather::pluck('name', 'id');
        $humidities = Humidity::pluck('name', 'id');

        return view(
            'app.daily_reports.create',
            compact('shipbuilding', 'dailyReport', 'weathers', 'humidities')
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

        $shipbuilding = Shipbuilding::where('id', $validated['shipbuilding_id'])->firstOrFail();
        $validated['week'] = Date::weekDiff($shipbuilding->start_date, $validated['date']);
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

        $shipbuilding = Shipbuilding::where('id', $validated['shipbuilding_id'])->firstOrFail();
        $validated['week'] = Date::weekDiff($shipbuilding->start_date, $validated['date']);
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

        $shipbuildingID = $dailyReport->shipbuilding_id;
        $dailyReport->delete();

        return redirect()
            ->route('shipbuildings.show', $shipbuildingID)
            ->withSuccess(__('crud.common.removed'));
    }
}
