<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WaspadaApiController;
use App\Http\Controllers\EdukasiDbdController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/titik-risiko', [WaspadaApiController::class, 'getTitikRisiko']);
Route::get('/titik-risiko/level/{level}', [WaspadaApiController::class, 'getTitikRisikoByLevel']);
Route::get('/titik-risiko/{id}', [WaspadaApiController::class, 'getTitikRisikoById']);
Route::get('/titik-risiko/{id}/pemeriksaan', [WaspadaApiController::class, 'getPemeriksaanByTitik']);
Route::post('/pemeriksaan-risiko', [WaspadaApiController::class, 'storePemeriksaan']);
Route::get('/edukasi', [EdukasiDbdController::class, 'getApiEdukasi']);
Route::get('/edukasi/{id}', [EdukasiDbdController::class, 'getApiEdukasiDetail']);

// Wilayah / Region API routes
Route::get('/provinsi', [WaspadaApiController::class, 'getProvinsi']);
Route::get('/kabupaten/{provinsi_id}', [WaspadaApiController::class, 'getKabupaten']);
Route::get('/kecamatan/{kabupaten_id}', [WaspadaApiController::class, 'getKecamatan']);