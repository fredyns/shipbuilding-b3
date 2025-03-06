<?php

use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\HumidityController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShipbuildingController;
use App\Http\Controllers\ShipbuildingTaskController;
use App\Http\Controllers\ShipTypeController;
use App\Http\Controllers\ShipyardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\WeeklyReportController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (
    EmailVerificationRequest $request
) {
    $request->fulfill();
    return redirect('/dashboard');
})
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::any('/home', fn() => redirect('/dashboard'));

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', [ShipbuildingController::class, 'summary'])
    ->name('dashboard');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::get('shipbuildings/{shipbuilding}/weeks', [ShipbuildingController::class, 'weeks'])
            ->name('shipbuildings.weeks');

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('users', UserController::class);
        Route::resource('ship-types', ShipTypeController::class);
        Route::resource('shipyards', ShipyardController::class);
        Route::resource('shipbuildings', ShipbuildingController::class);
        Route::resource(
            'shipbuilding-tasks',
            ShipbuildingTaskController::class
        );
        Route::resource('weekly-reports', WeeklyReportController::class);
        Route::resource('weathers', WeatherController::class);
        Route::resource('humidities', HumidityController::class);
        Route::resource('daily-reports', DailyReportController::class);
    });
