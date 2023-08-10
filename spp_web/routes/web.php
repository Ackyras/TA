<?php

use App\Http\Controllers\Dashboard\Archive\RequestController as ArchiveRequestController;
use App\Http\Controllers\Dashboard\ArchiveController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\FarmerController;
use App\Http\Controllers\Dashboard\VillageController;
use App\Http\Controllers\Dashboard\DistrictController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Request\RequestController;
use App\Http\Controllers\Dashboard\Setting\User\UserController;
use App\Http\Controllers\Dashboard\Setting\Program\ProgramController;
use App\Http\Controllers\Dashboard\Setting\Division\DivisionController;
use App\Http\Controllers\Dashboard\Setting\Period\PeriodController;
use App\Http\Controllers\Dashboard\Setting\SeedingController;
use App\Http\Controllers\StorageController;
use App\Http\Middleware\ArchiveMiddleware;
use App\Http\Middleware\ScopePeriod;

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
        Route::middleware(ScopePeriod::class)->resource(
            'programs',
            ProgramController::class,
            [
                'names' =>  'program'
            ]
        );

        Route::resource(
            'periods',
            PeriodController::class,
            [
                'names' =>  'period'
            ]
        );
        Route::controller(SeedingController::class)->prefix('seeding')->as('seeding.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'storeComplete')->name('store.complete');
        });
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

    Route::middleware(ScopePeriod::class)->group(function () {
        Route::prefix('requests')->as('request.')->group(function () {
            Route::get('/', [RequestController::class, 'index'])->name('index');
            Route::post('/', [RequestController::class, 'store'])->name('store');
            Route::get('/create', [RequestController::class, 'create'])->name('create');
            Route::get('/{request}', [RequestController::class, 'show'])->name('show');
            Route::put('/{instructorRequest}', [RequestController::class, 'update'])->name('update');
            Route::delete('/{request}', [RequestController::class, 'destroy'])->name('destroy');
            Route::match(['GET', 'DELETE'], '/dashboard/requests/{request}/attachment/{attachment}', [RequestController::class, 'destroyAttachment'])->name('attachment.destroy');
            Route::prefix('result')->as('result.')->group(function () {
                // Route::get('')
            });
        });
    });

    Route::middleware([ArchiveMiddleware::class, ScopePeriod::class])->prefix('archive')->as('archive.')->group(function () {
        Route::get('/', [ArchiveController::class, 'index'])->name('index');
        Route::prefix('{period}')->as('period.')->group(function () {
            Route::get('/', [ArchiveController::class, 'show'])->name('show');
            Route::prefix('requests')->as('request.')->group(function () {
                Route::get('/', [ArchiveRequestController::class, 'index'])->name('index');
                Route::post('/', [ArchiveRequestController::class, 'store'])->name('store');
                Route::get('/create', [ArchiveRequestController::class, 'create'])->name('create');
                Route::get('/{request}', [ArchiveRequestController::class, 'show'])->name('show');
                Route::put('/{instructorRequest}', [ArchiveRequestController::class, 'update'])->name('update');
                Route::delete('/{request}', [ArchiveRequestController::class, 'destroy'])->name('destroy');
                Route::match(['GET', 'DELETE'], '/dashboard/requests/{request}/attachment/{attachment}', [ArchiveRequestController::class, 'destroyAttachment'])->name('attachment.destroy');
            });
        });
    });
});

Route::middleware(['auth.storage'])->prefix('secured-storage')->as('storage.')->controller(StorageController::class)->group(function () {
    Route::get('{requestAttachment}', 'getRequestAttachment')->name('request-attachment');
    Route::get('{requestResultAttachment}', 'getRequestResultAttachment')->name('request-result-attachment');
});


require __DIR__ . '/auth.php';
