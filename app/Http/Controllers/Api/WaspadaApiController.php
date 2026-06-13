<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TitikRisiko;
use App\Models\PemeriksaanRisiko;
use Illuminate\Http\Request;

class WaspadaApiController extends Controller
{
    // 1. GET /api/titik-risiko (Menampilkan semua titik risiko)
    public function getTitikRisiko()
    {
        $data = TitikRisiko::where('status_aktif', true)->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // 2. GET /api/titik-risiko/level/{level} (Filter berdasarkan level risiko)
    public function getTitikRisikoByLevel($level)
    {
        $data = TitikRisiko::where('level_risiko_awal', $level)
                           ->where('status_aktif', true)->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // 3. GET /api/titik-risiko/{id}/pemeriksaan (Riwayat pemeriksaan 1 lokasi)
    public function getPemeriksaanByTitik($id)
    {
        // Mengambil data titik risiko beserta riwayat pemeriksaannya
        $data = PemeriksaanRisiko::where('titik_risiko_id', $id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // 4. POST /api/pemeriksaan-risiko (Petugas menambah riwayat pemeriksaan dari API)
    public function storePemeriksaan(Request $request)
    {
        // Validasi input
        $request->validate([
            'titik_risiko_id' => 'required|exists:titik_risikos,id',
            'petugas_id' => 'required|exists:users,id',
            'tanggal_pemeriksaan' => 'required|date',
            'ditemukan_jentik' => 'required|boolean',
            'kondisi_lingkungan' => 'required|string',
            'tindakan_dilakukan' => 'required|string',
            'status_akhir' => 'required|in:aman,perlu pemantauan,perlu tindakan'
        ]);

        $pemeriksaan = PemeriksaanRisiko::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data pemeriksaan berhasil ditambahkan',
            'data' => $pemeriksaan
        ], 201);
    }
}