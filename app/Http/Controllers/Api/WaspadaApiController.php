<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TitikRisiko;
use App\Models\PemeriksaanRisiko;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;

class WaspadaApiController extends Controller
{
    // 1. GET /api/titik-risiko (Menampilkan semua titik risiko dengan opsional filter wilayah)
    public function getTitikRisiko(Request $request)
    {
        // Hanya ambil data yang statusnya aktif DAN belum 'aman'
        $query = TitikRisiko::where('status_aktif', true)
                           ->where('level_risiko_awal', '!=', 'aman'); // Sesuaikan nama level jika perlu
        
        if ($request->filled('provinsi')) {
            $query->where('provinsi', $request->provinsi);
        }
        if ($request->filled('kabupaten_kota')) {
            $query->where('kabupaten_kota', $request->kabupaten_kota);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }
        
        $data = $query->get();
        
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

        // 1. Simpan data pemeriksaan
        $pemeriksaan = PemeriksaanRisiko::create($request->all());

        // 2. Mapping status ke level untuk update tabel titik_risikos
        $mapStatus = [
            'aman' => 'rendah',
            'perlu pemantauan' => 'sedang',
            'perlu tindakan' => 'tinggi'
        ];

        // 3. Update level_risiko_awal pada titik terkait
        $titik = TitikRisiko::find($request->titik_risiko_id);
        if ($titik) {
            $titik->update([
                'level_risiko_awal' => $mapStatus[$request->status_akhir]
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data pemeriksaan berhasil ditambahkan dan status lokasi diperbarui',
            'data' => $pemeriksaan
        ], 201);
    }

    // GET /api/titik-risiko/{id} (Menampilkan detail 1 titik risiko)
    public function getTitikRisikoById($id)
    {
        $data = TitikRisiko::find($id);
        
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // --- EDUKASI ---

    // 5. GET /api/edukasi (Menampilkan semua artikel edukasi)
    public function getEdukasi()
    {
        // Pastikan Anda sudah membuat Model Edukasi (misal: App\Models\Edukasi)
        // Jika belum, sesuaikan dengan nama Model yang Anda buat untuk tabel edukasi
        $data = \App\Models\Edukasi::latest()->get(); 
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // 6. GET /api/edukasi/{id} (Menampilkan detail 1 artikel edukasi)
    public function getEdukasiById($id)
    {
        $data = \App\Models\Edukasi::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel edukasi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // GET /api/provinsi
    public function getProvinsi()
    {
        $provinces = Province::orderBy('name')->get();
        return response()->json([
            'status' => 'success',
            'data' => $provinces
        ]);
    }

    // GET /api/kabupaten/{provinsi_id}
    public function getKabupaten($provinsi_id)
    {
        $provinsi = Province::where('id', $provinsi_id)
            ->orWhere('name', $provinsi_id)
            ->first();
        
        $cities = $provinsi ? $provinsi->cities()->orderBy('name')->get() : [];
        return response()->json([
            'status' => 'success',
            'data' => $cities
        ]);
    }

    // GET /api/kecamatan/{kabupaten_id}
    public function getKecamatan($kabupaten_id)
    {
        $kota = City::where('id', $kabupaten_id)
            ->orWhere('name', $kabupaten_id)
            ->first();
        
        $districts = $kota ? $kota->districts()->orderBy('name')->get() : [];
        return response()->json([
            'status' => 'success',
            'data' => $districts
        ]);
    }
}