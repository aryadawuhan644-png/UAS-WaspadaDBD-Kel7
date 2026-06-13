<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TitikRisikoController;
use App\Http\Controllers\PemeriksaanRisikoController;
use App\Models\TitikRisiko;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('titik-risiko', TitikRisikoController::class)
     ->middleware(['auth']);

Route::resource('pemeriksaan', PemeriksaanRisikoController::class)
     ->middleware(['auth']);

Route::get('/risiko-tinggi', function () {
    // Mencari titik risiko yang memiliki setidaknya satu pemeriksaan dengan status 'perlu tindakan'
    $data = TitikRisiko::whereHas('pemeriksaan', function($query) {
        $query->where('status_akhir', 'perlu tindakan');
    })->get();

    return view('laporan.risiko-tinggi', compact('data'));
})->middleware(['auth'])->name('risiko-tinggi');

require __DIR__.'/auth.php';
