<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('bilety')->name('tickets.')->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('index');
    Route::post('/platnosc', [TicketController::class, 'checkout'])->name('checkout');
    Route::post('/finalizacja', [TicketController::class, 'finalize'])->name('finalize');
});

Route::get('/mapa', [MapController::class, 'index'])->name('map');
Route::get('/api/enclosure/{id}', [MapController::class, 'getEnclosure'])->name('api.enclosure');

Route::get('/mieszkancy', [ResidentController::class, 'index'])->name('residents');

Route::get('/kontakt', [HomeController::class, 'contact'])->name('contact');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['can:is-employee'])->group(function () {
        Route::get('/grafik', [ScheduleController::class, 'index'])->name('schedule.index');
    });
    Route::middleware(['can:is-manager'])->group(function () {
        Route::get('/zarzadzanie-grafikiem', [ScheduleController::class, 'managerIndex'])
        ->name('schedule.manager');
        Route::get('/api/schedule/day/{date}', [ScheduleController::class, 'getDayData'])
        ->name('api.schedule.day');
        Route::post('/api/schedule/save', [ScheduleController::class, 'saveDayData'])
        ->name('api.schedule.save');
    });
});
