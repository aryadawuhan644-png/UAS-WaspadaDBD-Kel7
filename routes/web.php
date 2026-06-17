<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TitikRisikoController;
use App\Http\Controllers\PemeriksaanRisikoController;
use App\Http\Controllers\EdukasiDbdController;

// ==========================================
// 1. RUTE PUBLIK (WARGA / TANPA LOGIN)
// ==========================================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/edukasi', [EdukasiDbdController::class, 'indexPublik'])->name('edukasi.publik');
Route::get('/edukasi/{id}', [EdukasiDbdController::class, 'showPublik'])->name('edukasi.show');


// ==========================================
// 2. RUTE BERSAMA (ADMIN & PETUGAS)
// ==========================================
Route::middleware(['auth', 'verified', 'role:admin,petugas'])->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Kelola Profil Akun
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- TAMBAHAN RUTE KHUSUS TUGAS PETUGAS ---
    // Rute ini menangkap ID lokasi saat tombol "Gas Periksa" diklik
    Route::get('/pemeriksaan/create/{titik_id}', [PemeriksaanRisikoController::class, 'create'])->name('pemeriksaan.create');
    
    // CRUD Pemeriksaan Risiko standar
    Route::resource('pemeriksaan', PemeriksaanRisikoController::class)->except(['create']);
});


// ==========================================
// 3. RUTE KHUSUS ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::get('/titik-risiko/jumlah', [TitikRisikoController::class, 'jumlah'])->name('titik-risiko.jumlah');
    Route::resource('titik-risiko', TitikRisikoController::class);
    Route::get('/risiko-tinggi', [DashboardController::class, 'risikoTinggi'])->name('risiko-tinggi');

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