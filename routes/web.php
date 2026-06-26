<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TitikRisikoController;
use App\Http\Controllers\PemeriksaanRisikoController;
use App\Http\Controllers\EdukasiDbdController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\PetugasController;

// 1. RUTE PUBLIK
Route::get('/', function () {
    return redirect('/frontend-zayy');
});
Route::get('/backend', function () {
    return view('welcome');
});
Route::get('/edukasi', [EdukasiDbdController::class, 'indexPublik'])->name('edukasi.publik');
Route::get('/edukasi/{id}', [EdukasiDbdController::class, 'showPublik'])->name('edukasi.show');

// 2. RUTE BERSAMA (ADMIN & PETUGAS)
Route::middleware(['auth', 'verified', 'role:admin,petugas'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/get-kabupaten/{id}', [WilayahController::class, 'getKabupaten']);
    Route::get('/get-kecamatan/{id}', [WilayahController::class, 'getKecamatan']);

    Route::get('/pemeriksaan/create/{titik_id}', [PemeriksaanRisikoController::class, 'create'])->name('pemeriksaan.create');
    Route::resource('pemeriksaan', PemeriksaanRisikoController::class)->except(['create']);

    // PERBAIKAN DI SINI: Tambahkan ->except(['show'])
    Route::resource('titik-risiko', TitikRisikoController::class)->except(['show']);
});

// 3. RUTE KHUSUS ADMIN
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    
    Route::get('/titik-risiko/jumlah', [TitikRisikoController::class, 'jumlah'])->name('titik-risiko.jumlah');
    Route::get('/risiko-tinggi', [DashboardController::class, 'risikoTinggi'])->name('risiko-tinggi');

    Route::resource('petugas', PetugasController::class);

    Route::resource('admin/edukasi', EdukasiDbdController::class)->except(['show'])->names([
        'index'   => 'edukasi.index',
        'create'  => 'edukasi.create',
        'store'   => 'edukasi.store',
        'edit'    => 'edukasi.edit',
        'update'  => 'edukasi.update',
        'destroy' => 'edukasi.destroy',
    ]);
});

require __DIR__.'/auth.php';