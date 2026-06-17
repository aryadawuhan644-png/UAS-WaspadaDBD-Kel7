<?php

namespace App\Http\Controllers;

use App\Models\TitikRisiko;
use App\Models\PemeriksaanRisiko;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        $data = [
            'total_titik' => TitikRisiko::count(),
            'risiko_tinggi' => TitikRisiko::highRisk()->count(),
            'pemeriksaan_bulan_ini' => PemeriksaanRisiko::whereMonth('tanggal_pemeriksaan', $currentMonth)
                                        ->whereYear('tanggal_pemeriksaan', $currentYear)->count(),
            
            // Logic Tugas: Hanya tampilkan titik yang BELUM ada pemeriksaan di bulan ini
            'titik_risikos' => TitikRisiko::whereDoesntHave('pemeriksaan', function($query) use ($currentMonth, $currentYear) {
                $query->whereMonth('tanggal_pemeriksaan', $currentMonth)
                      ->whereYear('tanggal_pemeriksaan', $currentYear);
            })->get(), 
        ];

        return view('dashboard', $data);
    }

    public function risikoTinggi()
    {
        $data = TitikRisiko::highRisk()->get();
        return view('laporan.risiko_tinggi', compact('data'));
    }
}