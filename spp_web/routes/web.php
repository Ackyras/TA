<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\User\UserController;
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
});


require __DIR__ . '/auth.php';
