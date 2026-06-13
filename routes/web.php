<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TitikRisikoController;
use App\Http\Controllers\PemeriksaanRisikoController;


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


// Rute untuk halaman kartu risiko tinggi khusus admin/petugas
Route::get('/risiko-tinggi', [DashboardController::class, 'risikoTinggi'])
    ->middleware(['auth'])
    ->name('risiko-tinggi');

require __DIR__.'/auth.php';
