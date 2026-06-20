<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;

class WilayahController extends Controller
{
    public function getKabupaten($id)
    {
        // Cari berdasarkan ID (angka) ATAU Nama (teks)
        $provinsi = Province::where('id', $id)->orWhere('name', $id)->first();
        
        if ($provinsi) {
            return response()->json($provinsi->cities);
        }
        
        return response()->json([]);
    }

    public function getKecamatan($id)
    {
        // Cari berdasarkan ID (angka) ATAU Nama (teks)
        $kota = City::where('id', $id)->orWhere('name', $id)->first();
        
        if ($kota) {
            return response()->json($kota->districts);
        }
        
        return response()->json([]);
    }
}