<?php

namespace App\Http\Controllers;

use App\Models\TitikRisiko;
use App\Models\PemeriksaanRisiko;
use App\Models\Petugas;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        $user = auth()->user();

        // Ambil data petugas di awal
        $petugas = null;
        $namaKecamatan = null;

        if ($user->role === 'petugas') {
            $petugas = Petugas::where('user_id', $user->id)->first();
            if ($petugas) {
                $namaKecamatan = \Laravolt\Indonesia\Models\District::find($petugas->kecamatan)?->name ?? $petugas->kecamatan;
            }
        }

        $query = TitikRisiko::query();

        if ($user->role === 'petugas') {
            if ($petugas) {
                $query->where('kecamatan', 'like', trim($namaKecamatan));
            } else {
                $query->where('id', 0);
            }
        }

        // --- Logika Grafik Admin: Tren Penambahan Titik Risiko ---
        $labels = [];
        $dataGrafik = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->translatedFormat('F');
            $dataGrafik[] = (clone $query)->whereMonth('created_at', $date->month)
                                         ->whereYear('created_at', $date->year)
                                         ->count();
        }

        // --- Logika Grafik Petugas: Statistik Pemeriksaan Selesai ---
        $labelsPemeriksaan = [];
        $dataPemeriksaan = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labelsPemeriksaan[] = $date->translatedFormat('F');
            
            $dataPemeriksaan[] = PemeriksaanRisiko::whereMonth('tanggal_pemeriksaan', $date->month)
                ->whereYear('tanggal_pemeriksaan', $date->year)
                ->whereHas('titikRisiko', function($q) use ($user, $petugas, $namaKecamatan) {
                    if ($user->role === 'petugas' && $petugas) {
                        $q->where('kecamatan', 'like', trim($namaKecamatan));
                    }
                })->count();
        }

        $data = [
            'total_titik' => (clone $query)->count(),
            'risiko_tinggi' => (clone $query)->where('level_risiko_awal', 'tinggi')->count(),
            'pemeriksaan_bulan_ini' => PemeriksaanRisiko::whereMonth('tanggal_pemeriksaan', $currentMonth)
                ->whereYear('tanggal_pemeriksaan', $currentYear)
                ->whereHas('titikRisiko', function($q) use ($user, $petugas, $namaKecamatan) {
                    if ($user->role === 'petugas') {
                        if ($petugas) { $q->where('kecamatan', 'like', trim($namaKecamatan)); } 
                        else { $q->where('id', 0); }
                    }
                })->count(),
            'titik_risikos' => (clone $query)->whereDoesntHave('pemeriksaan', function($q) use ($currentMonth, $currentYear) {
                $q->whereMonth('tanggal_pemeriksaan', $currentMonth)
                  ->whereYear('tanggal_pemeriksaan', $currentYear);
            })->get(),
            'labels' => $labels,
            'dataGrafik' => $dataGrafik,
            'labelsPemeriksaan' => $labelsPemeriksaan,
            'dataPemeriksaan' => $dataPemeriksaan,
        ];

        return view('dashboard', $data);
    }

    public function risikoTinggi(): View
    {
        $user = auth()->user();

        $query = TitikRisiko::query();

        // Jika role petugas, batasi berdasarkan kecamatan petugas
        if ($user->role === 'petugas') {
            $petugas = Petugas::where('user_id', $user->id)->first();
            $namaKecamatan = $petugas ? (\Laravolt\Indonesia\Models\District::find($petugas->kecamatan)?->name ?? $petugas->kecamatan) : null;
            if ($petugas && $namaKecamatan) {
                $query->where('kecamatan', 'like', trim($namaKecamatan));
            } else {
                $query->where('id', 0);
            }
        }

        $titikRisikoTinggi = $query->where('level_risiko_awal', 'tinggi')->latest()->get();

        return view('laporan.risiko-tinggi', [
            'titikRisikoTinggi' => $titikRisikoTinggi,
        ]);
    }
}