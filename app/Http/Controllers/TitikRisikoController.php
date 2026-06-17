<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TitikRisiko;

class TitikRisikoController extends Controller
{
    public function index(Request $request) // <--- Tambahkan Request $request di sini
    {
        // 1. Siapkan builder query dasar
        $query = TitikRisiko::query();

        // 2. Filter berdasarkan Level Risiko jika user memilih salah satu level
        if ($request->filled('level')) {
            $query->where('level_risiko_awal', $request->level);
        }

        // 3. Filter berdasarkan Wilayah jika user mengetik sesuatu (menggunakan 'like' agar pencarian fleksibel)
        if ($request->filled('wilayah')) {
            $query->where('rt_rw', 'like', '%' . $request->wilayah . '%');
        }

        // 4. Ambil data hasil filter dengan urutan data terbaru di atas
        $titikRisikos = $query->latest()->get();

        // 5. Kembalikan ke view 'titik_risiko.index' sesuai struktur foldermu
        return view('titik_risiko.index', compact('titikRisikos'));
    }

    public function jumlah()
{
    // Mengambil semua data untuk ditampilkan di kotak-kotak
    $titik_risikos = \App\Models\TitikRisiko::all();
    
    // UBAH BAGIAN INI: pakai underscore (titik_risiko) bukan strip
    return view('titik_risiko.jumlah', compact('titik_risikos'));
}

    public function create()
    {
        return view('titik_risiko.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_titik'        => 'required|string|max:255',
            'alamat'            => 'required|string',
            'rt_rw'             => 'required|string|max:20',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'jenis_risiko'      => 'required|in:genangan,barang bekas,saluran air,tempat sampah',
            'level_risiko_awal' => 'required|in:rendah,sedang,tinggi',
        ]);

        // Perbaikan kecil: ubah '? true : true' menjadi langsung '$request->has' 
        // agar nilai checkbox bisa bernilai false jika tidak dicentang
        $validated['status_aktif'] = $request->has('status_aktif');

        TitikRisiko::create($validated);

        return redirect()->route('titik-risiko.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $titik = TitikRisiko::findOrFail($id);
        return view('titik_risiko.edit', compact('titik'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_titik'        => 'required|string|max:255',
            'alamat'            => 'required|string',
            'rt_rw'             => 'required|string|max:20',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'jenis_risiko'      => 'required|in:genangan,barang bekas,saluran air,tempat sampah',
            'level_risiko_awal' => 'required|in:rendah,sedang,tinggi',
        ]);

        $validated['status_aktif'] = $request->has('status_aktif');

        TitikRisiko::findOrFail($id)->update($validated);
        
        return redirect()->route('titik-risiko.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        TitikRisiko::findOrFail($id)->delete();
        return redirect()->route('titik-risiko.index')->with('success', 'Data berhasil dihapus!');
    }
}