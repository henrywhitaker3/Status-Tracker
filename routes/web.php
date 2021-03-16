<?php

use App\Http\Controllers\ServiceCheckController;
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
    return Service::with([
        'recentChecks' => function ($query) {
            return $query->limit(16);
        }
    ])->findOrFail($id);
});

Route::get('/', [ServicesController::class, 'index'])->name('servics.index');

Route::prefix('services')->group(function () {
    Route::get('/create', [ServicesController::class, 'create'])->name('services.create');
    Route::put('/', [ServicesController::class, 'store'])->name('services.store');
    Route::get('/{service}', [ServicesController::class, 'show'])->name('services.show')->middleware('remember');
    Route::delete('/{service}', [ServicesController::class, 'destroy'])->name('services.destroy');
});

Route::prefix('checks')->group(function () {
    Route::get('/{serviceCheck}', [ServiceCheckController::class, 'show'])->name('checks.show');
});
