<?php

use App\Http\Controllers\ServicesController;
use App\Models\Service;
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

Route::bind('service_with_recent', function ($id) {
    return Service::with('recentChecks')->findOrFail($id);
});

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('services')->group(function () {
    Route::get('/', [ServicesController::class, 'index'])->name('services.index');
    Route::get('/create', [ServicesController::class, 'create'])->name('services.create');
    Route::put('/', [ServicesController::class, 'store'])->name('services.store');
    Route::get('/{service_with_recent}', [ServicesController::class, 'show'])->name('services.show');
});
