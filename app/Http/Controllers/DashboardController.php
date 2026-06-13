<?php

namespace App\Http\Controllers; // Ini harus ada!

use App\Models\TitikRisiko;
use App\Models\PemeriksaanRisiko;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $data = [
            'total_titik' => TitikRisiko::count(),
            'risiko_tinggi' => TitikRisiko::where('level_risiko_awal', 'tinggi')->count(),
            'pemeriksaan_bulan_ini' => PemeriksaanRisiko::whereMonth('tanggal_pemeriksaan', date('m'))->count(),
        ];

        return view('dashboard', $data);
    }
}