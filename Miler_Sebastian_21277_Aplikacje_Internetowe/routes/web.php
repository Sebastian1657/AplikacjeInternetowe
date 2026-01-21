<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\AnimalManagementController;
use App\Http\Controllers\AdminController;


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

    Route::middleware(['can:is-supervisor'])->prefix('kierownik')->name('supervisor.')->group(function () {
        Route::resource('pracownicy', EmployeeController::class)
            ->names('employees')
            ->parameters(['pracownicy' => 'employee']);
        
        Route::resource('diety', DietController::class)
        ->names('diets')
        ->parameters(['diety' => 'diet']);

        Route::get('diety/{diet}/przypisz', [DietController::class, 'assignForm'])
        ->name('diets.assign');

        Route::post('diety/{diet}/przypisz', [DietController::class, 'processAssign'])
        ->name('diets.process_assign');

        Route::controller(AnimalManagementController::class)
        ->prefix('zwierzeta')
        ->name('animals.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            
            Route::post('/gatunek', 'storeSpecies')->name('species.store');
            Route::delete('/gatunek/{species}', 'destroySpecies')->name('species.destroy');

            Route::get('/podgatunek/dodaj/{species}', 'createSubspecies')->name('subspecies.create');
            Route::post('/podgatunek', 'storeSubspecies')->name('subspecies.store');
            Route::delete('/podgatunek/{subspecies}', 'destroySubspecies')->name('subspecies.destroy');

            Route::get('/zwierze/dodaj/{subspecies}', 'createAnimal')->name('create');
            Route::post('/zwierze', 'storeAnimal')->name('store');
            Route::delete('/zwierze/{animal}', 'destroyAnimal')->name('destroy');
        });
    });

    Route::middleware(['can:is-administrator'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.table.index', 'users'); 
        })->name('dashboard');

        Route::get('/tabela/{tableName}', [AdminController::class, 'index'])->name('table.index');
        Route::get('/tabela/{tableName}/dodaj', [AdminController::class, 'create'])->name('table.create');
        Route::post('/tabela/{tableName}', [AdminController::class, 'store'])->name('table.store');
        Route::get('/tabela/{tableName}/{id}/edytuj', [AdminController::class, 'edit'])->name('table.edit');
        Route::put('/tabela/{tableName}/{id}', [AdminController::class, 'update'])->name('table.update');
        Route::delete('/tabela/{tableName}/{id}', [AdminController::class, 'destroy'])->name('table.destroy');
    });
});
