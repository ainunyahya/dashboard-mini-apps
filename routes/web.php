<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\HutangPiutangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function(){
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index');
    });
    Route::controller(HutangPiutangController::class)->group(function () {
        Route::get('hutangpiutang', 'index');
    });
    Route::controller(ManagementController::class)->group(function () {
        Route::get('management', 'index');
    });
    Route::prefix('demo')->group(function () {
        Route::get('/', [DemoController::class, 'index'])->name('demo.index');
        Route::get('/create', [DemoController::class, 'create']);
        Route::post('/', [DemoController::class, 'store'])->name('demo.store');
        Route::get('/detail/{id}', [DemoController::class, 'show'])->name('detail.show');
        Route::get('/{id}/edit', [DemoController::class, 'edit'])->name('demo.edit');
        Route::put('/{id}/edit', [DemoController::class, 'update'])->name('demo.edit');
        Route::delete('/{id}', [DemoController::class, 'destroy'])->name('demo.destroy');
    });
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
