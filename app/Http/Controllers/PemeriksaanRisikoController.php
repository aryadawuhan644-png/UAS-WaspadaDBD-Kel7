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
    $query = PemeriksaanRisiko::with(['titikRisiko', 'petugas']);
    $filterBulan = date('Y-m'); // Default untuk filter admin

    // 1. Logika Jika yang login adalah ADMIN
    if (auth()->user()->role === 'admin') {
        $filterBulan = $request->input('bulan', date('Y-m'));
        $query->whereYear('tanggal_pemeriksaan', date('Y', strtotime($filterBulan)))
              ->whereMonth('tanggal_pemeriksaan', date('m', strtotime($filterBulan)));
    } 
    // 2. Logika Jika yang login adalah PETUGAS (CRUD Lama)
    else {
        if ($request->filled('status')) {
            $query->where('status_akhir', $request->status);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pemeriksaan', $request->tanggal);
        }
    }

    $pemeriksaans = $query->latest()->get();

    return view('pemeriksaan.index', compact('pemeriksaans', 'filterBulan'));
}

    /**
     * Show the form for creating a new resource.
     * Sekarang menerima $titik_id dari route
     */
    public function create($titik_id)
    {
        // Cari titik risiko spesifik berdasarkan ID
        $titik = TitikRisiko::findOrFail($titik_id);
        
        // Kirim $titik ke view untuk ditampilkan di form (Read-only)
        return view('pemeriksaan.create', compact('titik'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Tambahkan petugas_id otomatis dari user yang login
        $request->merge(['petugas_id' => Auth::id()]);

        // 2. Validasi
        $validated = $request->validate([
            'titik_risiko_id'   => 'required|exists:titik_risikos,id',
            'petugas_id'        => 'required|exists:users,id',
            'tanggal_pemeriksaan'=> 'required|date',
            'ditemukan_jentik'   => 'required|boolean',
            'kondisi_lingkungan' => 'required|string',
            'tindakan_dilakukan' => 'required|string',
            'status_akhir'       => 'required|in:aman,perlu pemantauan,perlu tindakan',
        ]);

        // 3. Simpan ke database
        PemeriksaanRisiko::create($validated);

        return redirect()->route('dashboard')->with('success', 'Data pemeriksaan berhasil ditambahkan!');
    }

    // ... (Metode show, edit, update, destroy tetap sama) ...
    
    public function edit(string $id)
    {
        $pemeriksaan = PemeriksaanRisiko::findOrFail($id);
        $titikRisikos = TitikRisiko::all(); // Tetap butuh ini jika petugas mau ubah titik
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
        ]);

        PemeriksaanRisiko::findOrFail($id)->update($validated);
    
        return redirect()->route('pemeriksaan.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        PemeriksaanRisiko::findOrFail($id)->delete();
        return redirect()->route('pemeriksaan.index')->with('success', 'Data dihapus!');
    }
}