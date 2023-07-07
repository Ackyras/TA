<?php

use App\Http\Controllers\Coordinator\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\FarmerController;
use App\Http\Controllers\Dashboard\VillageController;
use App\Http\Controllers\Dashboard\DistrictController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Setting\User\UserController;
use App\Http\Controllers\Dashboard\Setting\Program\ProgramController;
use App\Http\Controllers\Dashboard\Setting\Division\DivisionController;

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
    return view('welcome');
});

Route::impersonate();

Route::middleware(['auth'])->prefix('dashboard')->as('dashboard.')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('', 'index')->name('index');
    });

    Route::prefix('settings')->as('setting.')->group(function () {
        Route::resource(
            'users',
            UserController::class,
            [
                'names'    =>  'user',
            ]
        );
        Route::resource(
            'divisions',
            DivisionController::class,
            [
                'names'    =>  'division',
            ]
        );
        Route::resource(
            'programs',
            ProgramController::class,
            [
                'names' =>  'program'
            ]
        );
    });

    Route::resource(
        'districts',
        DistrictController::class,
        [
            'names' =>  'district',
        ]
    );

    Route::resource(
        'villages',
        VillageController::class,
        [
            'names' =>  'village',
        ]
    );
    Route::resource(
        'farmers',
        FarmerController::class,
        [
            'names' =>  'farmer',
        ],
    );

    Route::controller(VillageController::class)->group(function () {
        Route::prefix('districts/{district}/village')->as('district.village.')->group(
            function () {
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('{village}', 'show')->name('show');
                Route::get('{village}/edit', 'edit')->name('edit');
                Route::put('{village}', 'update')->name('update');
                Route::delete('{village}', 'destroy')->name('destroy');
            }
        );
    });
});

Route::controller(SettingController::class)->group(function () {
    Route::get('index', 'index')->name('index');
});


require __DIR__ . '/auth.php';
