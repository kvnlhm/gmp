<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ProduktivitasHSPDController;
use App\Http\Controllers\ProduktivitasHarianController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProfilController;

// Root Route
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/monitoring');
    }
    return redirect('/login');
});

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::put('/monitoring/{id}', [MonitoringController::class, 'update'])->name('monitoring.update');
    Route::delete('/monitoring/{id}', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');
    Route::get('/produktivitas-hspd', [ProduktivitasHSPDController::class, 'index'])->name('produktivitas-hspd.index');
    Route::get('/produktivitas-harian', [ProduktivitasHarianController::class, 'index'])->name('produktivitas-harian.index');
    
    // Pengguna Routes
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::put('/pengguna/{user}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{user}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
    
    // Profil Routes
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

// Mobile Routes
Route::prefix('mobile')->name('mobile.')->group(function () {
    Route::get('/monitoring', [MonitoringController::class, 'create'])->name('monitoring');
    Route::post('/monitoring', [MonitoringController::class, 'store'])->name('monitoring.store');
    Route::get('/stopwatch', [MonitoringController::class, 'stopwatch'])->name('stopwatch');
    Route::get('/stopwatch/new', [MonitoringController::class, 'createNew'])->name('stopwatch.new');
    Route::post('/monitoring/update-time', [MonitoringController::class, 'updateTime'])->name('monitoring.update.time');
    Route::get('/final-input/{id}', [MonitoringController::class, 'finalInput'])->name('final.input');
    Route::post('/final-input/{id}', [MonitoringController::class, 'saveFinalInput'])->name('final.input.save');
    Route::get('/recap', [MonitoringController::class, 'recap'])->name('recap');
    Route::post('/monitoring/update-time-new', [MonitoringController::class, 'updateTimeNew'])->name('monitoring.update.time.new');
    Route::get('/final-input-new/{id}', [MonitoringController::class, 'finalInputNew'])->name('final.input.new');
    Route::post('/final-input-new/{id}', [MonitoringController::class, 'saveFinalInputNew'])->name('final.input.save.new');
});

// Route untuk API
Route::group(['prefix' => 'api'], function () {
    Route::post('monitoring', [MonitoringController::class, 'store']);
    Route::put('monitoring/{id}/timer', [MonitoringController::class, 'updateTimer']);
    Route::post('monitoring/{id}/finish', [MonitoringController::class, 'finish']);
});
