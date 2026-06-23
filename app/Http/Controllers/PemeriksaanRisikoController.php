<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TitikRisiko;
use App\Models\PemeriksaanRisiko;
// Import untuk dropdown wilayah
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;

class PemeriksaanRisikoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PemeriksaanRisiko::with(['titikRisiko', 'petugas']);
        $filterBulan = $request->input('bulan', date('Y-m'));
        $provinces = Province::all(); 

        // 1. Logika Jika yang login adalah ADMIN
        if (auth()->user()->role === 'admin') {
            // Filter Bulan (Wajib)
            $query->whereYear('tanggal_pemeriksaan', date('Y', strtotime($filterBulan)))
                  ->whereMonth('tanggal_pemeriksaan', date('m', strtotime($filterBulan)));
            
            // --- FILTER WILAYAH (LENGKAP) ---
            if ($request->filled('provinsi')) {
                $query->whereHas('titikRisiko', function($q) use ($request) {
                    $q->where('provinsi', $request->provinsi);
                });
            }
            if ($request->filled('kabupaten_kota')) {
                $query->whereHas('titikRisiko', function($q) use ($request) {
                    $q->where('kabupaten_kota', $request->kabupaten_kota);
                });
            }
            if ($request->filled('kecamatan')) {
                $query->whereHas('titikRisiko', function($q) use ($request) {
                    $q->where('kecamatan', $request->kecamatan);
                });
            }
            // --- END FILTER ---
        } 
        // 2. Logika Jika yang login adalah PETUGAS
        else {
            $petugas = \App\Models\Petugas::where('user_id', auth()->id())->first();
            if ($petugas) {
                // Terjemahkan ID kecamatan petugas ke Nama Kecamatan
                $namaKecamatan = \Laravolt\Indonesia\Models\District::find($petugas->kecamatan)?->name ?? $petugas->kecamatan;

                // Filter data berdasarkan wilayah petugas
                $query->whereHas('titikRisiko', function($q) use ($namaKecamatan) {
                    $q->where('kecamatan', 'like', trim($namaKecamatan));
                });
            }

            if ($request->filled('status')) {
                $query->where('status_akhir', $request->status);
            }
            if ($request->filled('tanggal')) {
                $query->whereDate('tanggal_pemeriksaan', $request->tanggal);
            }
        }

        $pemeriksaans = $query->latest()->get();

        return view('pemeriksaan.index', compact('pemeriksaans', 'filterBulan', 'provinces'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mengambil data pemeriksaan beserta relasi titik risiko dan petugasnya
        $pemeriksaan = PemeriksaanRisiko::with(['titikRisiko', 'petugas'])->findOrFail($id);

        return view('pemeriksaan.show', compact('pemeriksaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($titik_id)
    {
        $titik = TitikRisiko::findOrFail($titik_id);
        return view('pemeriksaan.create', compact('titik'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titik_risiko_id'    => 'required|exists:titik_risikos,id',
            'tanggal_pemeriksaan'=> 'required|date',
            'ditemukan_jentik'   => 'required|boolean',
            'kondisi_lingkungan' => 'required|string',
            'tindakan_dilakukan' => 'required|string',
            'status_akhir'       => 'required|in:aman,perlu pemantauan,perlu tindakan',
            'foto'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pemeriksaan = new PemeriksaanRisiko($validated);
        $pemeriksaan->petugas_id = Auth::id(); 

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_pemeriksaan', 'public');
            $pemeriksaan->foto = $path;
        }

        $pemeriksaan->save();

        $mapStatus = [
            'aman' => 'rendah',
            'perlu pemantauan' => 'sedang',
            'perlu tindakan' => 'tinggi'
        ];
        $titik = TitikRisiko::find($request->titik_risiko_id);
        if ($titik) {
            $titik->update([
                'level_risiko_awal' => $mapStatus[$request->status_akhir]
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Data pemeriksaan berhasil ditambahkan!');
    }
    
    public function edit(string $id)
    {
        $pemeriksaan = PemeriksaanRisiko::findOrFail($id);
        $titikRisikos = TitikRisiko::all(); 
        return view('pemeriksaan.edit', compact('pemeriksaan', 'titikRisikos'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'titik_risiko_id'    => 'required|exists:titik_risikos,id',
            'tanggal_pemeriksaan'=> 'required|date',
            'ditemukan_jentik'   => 'required|boolean',
            'kondisi_lingkungan' => 'required|string',
            'tindakan_dilakukan' => 'required|string',
            'status_akhir'       => 'required|in:aman,perlu pemantauan,perlu tindakan',
            'foto_akhir'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pemeriksaan = PemeriksaanRisiko::findOrFail($id);

        $pemeriksaan->titik_risiko_id     = $request->titik_risiko_id;
        $pemeriksaan->tanggal_pemeriksaan = $request->tanggal_pemeriksaan;
        $pemeriksaan->ditemukan_jentik    = $request->ditemukan_jentik;
        $pemeriksaan->kondisi_lingkungan  = $request->kondisi_lingkungan;
        $pemeriksaan->tindakan_dilakukan  = $request->tindakan_dilakukan;
        $pemeriksaan->status_akhir        = $request->status_akhir;

        if ($request->hasFile('foto_akhir')) {
            if ($pemeriksaan->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pemeriksaan->foto);
            }
            $path = $request->file('foto_akhir')->store('foto_pemeriksaan', 'public');
            $pemeriksaan->foto = $path; 
        }

        $pemeriksaan->save();

        $mapStatus = [
            'aman' => 'rendah',
            'perlu pemantauan' => 'sedang',
            'perlu tindakan' => 'tinggi'
        ];
        $titik = TitikRisiko::find($request->titik_risiko_id);
        if ($titik) {
            $titik->update([
                'level_risiko_awal' => $mapStatus[$request->status_akhir]
            ]);
        }
        
        return redirect()->route('pemeriksaan.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        PemeriksaanRisiko::findOrFail($id)->delete();
        return redirect()->route('pemeriksaan.index')->with('success', 'Data dihapus!');
    }
}