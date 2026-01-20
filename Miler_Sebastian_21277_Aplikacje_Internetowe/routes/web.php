<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;


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