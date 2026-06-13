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
            'risiko_tinggi' => TitikRisiko::highRisk()->count(),
            'pemeriksaan_bulan_ini' => PemeriksaanRisiko::whereMonth('tanggal_pemeriksaan', date('m'))->count(),
        ];

        return view('dashboard', $data);
    }

    public function risikoTinggi()
    {
        // Mengambil data titik risiko yang dianggap berisiko tinggi
        $data = TitikRisiko::highRisk()->get();

        return view('laporan.risiko_tinggi', compact('data'));
    }
}