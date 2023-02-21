<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DistrictController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\Dashboard\VillageController;
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
    return view('welcome');
});

Route::middleware(['auth'])->prefix('dashboard')->as('dashboard.')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('', 'index')->name('index');
    });

    Route::resource(
        'users',
        UserController::class,
        [
            'names'    =>  'user'
        ]
    );

    Route::resource(
        'districts',
        DistrictController::class,
        [
            'names' =>  'district'
        ]
    );

    Route::controller(VillageController::class)->group(function () {
        // Route::get('/', 'index')->name('index');
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


require __DIR__ . '/auth.php';
