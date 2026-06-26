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

// =======================================================
// Grafik Admin : Penambahan Titik Risiko 7 Hari Terakhir
// =======================================================

$labels = [];
$dataGrafik = [];
$risikoRendahGrafik = [];
$risikoSedangGrafik = [];
$risikoTinggiGrafik = [];

for ($i = 6; $i >= 0; $i--) {

    $tanggal = now()->subDays($i);

    $labels[] = $tanggal->translatedFormat('D');

    $dataGrafik[] = (clone $query)
        ->whereDate('created_at', $tanggal->toDateString())
        ->count();

    $risikoRendahGrafik[] = (clone $query)
        ->whereDate('created_at', $tanggal->toDateString())
        ->where('level_risiko_awal', 'rendah')
        ->count();

    $risikoSedangGrafik[] = (clone $query)
        ->whereDate('created_at', $tanggal->toDateString())
        ->where('level_risiko_awal', 'sedang')
        ->count();

    $risikoTinggiGrafik[] = (clone $query)
        ->whereDate('created_at', $tanggal->toDateString())
        ->where('level_risiko_awal', 'tinggi')
        ->count();
}


// =======================================================
// Grafik Petugas : Pemeriksaan 7 Hari Terakhir
// =======================================================

$labelsPemeriksaan = [];
$dataPemeriksaan = [];
$risikoRendahPemeriksaan = [];
$risikoSedangPemeriksaan = [];
$risikoTinggiPemeriksaan = [];

for ($i = 6; $i >= 0; $i--) {

    $tanggal = now()->subDays($i);

    $labelsPemeriksaan[] = $tanggal->translatedFormat('D');

    $dataPemeriksaan[] = PemeriksaanRisiko::whereDate(
            'tanggal_pemeriksaan',
            $tanggal->toDateString()
        )
        ->whereHas('titikRisiko', function ($q) use ($user, $petugas, $namaKecamatan) {
            if ($user->role === 'petugas' && $petugas) {
                $q->where('kecamatan', 'like', trim($namaKecamatan));
            }
        })
        ->count();

    $risikoRendahPemeriksaan[] = PemeriksaanRisiko::whereDate(
            'tanggal_pemeriksaan',
            $tanggal->toDateString()
        )
        ->whereHas('titikRisiko', function ($q) use ($user, $petugas, $namaKecamatan) {
            if ($user->role === 'petugas' && $petugas) {
                $q->where('kecamatan', 'like', trim($namaKecamatan));
            }
            $q->where('level_risiko_awal', 'rendah');
        })
        ->count();

    $risikoSedangPemeriksaan[] = PemeriksaanRisiko::whereDate(
            'tanggal_pemeriksaan',
            $tanggal->toDateString()
        )
        ->whereHas('titikRisiko', function ($q) use ($user, $petugas, $namaKecamatan) {
            if ($user->role === 'petugas' && $petugas) {
                $q->where('kecamatan', 'like', trim($namaKecamatan));
            }
            $q->where('level_risiko_awal', 'sedang');
        })
        ->count();

    $risikoTinggiPemeriksaan[] = PemeriksaanRisiko::whereDate(
            'tanggal_pemeriksaan',
            $tanggal->toDateString()
        )
        ->whereHas('titikRisiko', function ($q) use ($user, $petugas, $namaKecamatan) {
            if ($user->role === 'petugas' && $petugas) {
                $q->where('kecamatan', 'like', trim($namaKecamatan));
            }
            $q->where('level_risiko_awal', 'tinggi');
        })
        ->count();
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
            'risikoRendahGrafik' => $risikoRendahGrafik,
            'risikoSedangGrafik' => $risikoSedangGrafik,
            'risikoTinggiGrafik' => $risikoTinggiGrafik,
            'labelsPemeriksaan' => $labelsPemeriksaan,
            'dataPemeriksaan' => $dataPemeriksaan,
            'risikoRendahPemeriksaan' => $risikoRendahPemeriksaan,
            'risikoSedangPemeriksaan' => $risikoSedangPemeriksaan,
            'risikoTinggiPemeriksaan' => $risikoTinggiPemeriksaan,
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