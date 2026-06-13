<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TitikRisiko;
use App\Models\PemeriksaanRisiko;

class PemeriksaanRisikoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Siapkan query dengan relasi
        $query = PemeriksaanRisiko::with(['titikRisiko', 'petugas']);

        // 2. Filter berdasarkan Status Akhir (dari dropdown)
        if ($request->filled('status')) {
            $query->where('status_akhir', $request->status);
        }

        // 3. Filter berdasarkan Tanggal (opsional)
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pemeriksaan', $request->tanggal);
        }

        // 4. Ambil data
        $pemeriksaans = $query->latest()->get();
    
        return view('pemeriksaan.index', compact('pemeriksaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil semua titik risiko untuk pilihan di form
        $titikRisikos = TitikRisiko::all();
        return view('pemeriksaan.create', compact('titikRisikos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. Tambahkan petugas_id otomatis dari user yang login
    $request->merge(['petugas_id' => Auth::id()]);

    // 2. Validasi dengan pesan error yang lebih jelas
        $validated = $request->validate([
            'titik_risiko_id'    => 'required|exists:titik_risikos,id',
            'petugas_id'         => 'required|exists:users,id',
            'tanggal_pemeriksaan'=> 'required|date',
            'ditemukan_jentik'   => 'required|boolean',
            'kondisi_lingkungan' => 'required|string',
            'tindakan_dilakukan' => 'required|string',
            'status_akhir'       => 'required|in:aman,perlu pemantauan,perlu tindakan',
        ]);

    // 3. Simpan ke database
    PemeriksaanRisiko::create($validated);

    return redirect()->route('pemeriksaan.index')->with('success', 'Data berhasil ditambahkan!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pemeriksaan = \App\Models\PemeriksaanRisiko::findOrFail($id);
        $titikRisikos = \App\Models\TitikRisiko::all();
        return view('pemeriksaan.edit', compact('pemeriksaan', 'titikRisikos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
        'titik_risiko_id'    => 'required|exists:titik_risikos,id',
        'tanggal_pemeriksaan'=> 'required|date',
        'ditemukan_jentik'   => 'required|boolean',
        'kondisi_lingkungan' => 'required|string',
        'tindakan_dilakukan' => 'required|string',
        'status_akhir'       => 'required|in:aman,perlu pemantauan,perlu tindakan',
    ]);

        \App\Models\PemeriksaanRisiko::findOrFail($id)->update($validated);
    
        return redirect()->route('pemeriksaan.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        \App\Models\PemeriksaanRisiko::findOrFail($id)->delete();
    return redirect()->route('pemeriksaan.index')->with('success', 'Data dihapus!');
    }
}
