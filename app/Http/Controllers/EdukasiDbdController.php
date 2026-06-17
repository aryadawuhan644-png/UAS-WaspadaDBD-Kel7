<?php

namespace App\Http\Controllers;

use App\Models\EdukasiDbd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EdukasiDbdController extends Controller
{
    // ==========================================
    // 1. AREA WARGA (PUBLIK - TANPA LOGIN)
    // ==========================================
    
    public function indexPublik(Request $request)
    {
        $query = EdukasiDbd::latest();

        // Fitur Warga: Filter berdasarkan Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $edukasi = $query->get();
        return view('edukasi.publik', compact('edukasi'));
    }

    public function showPublik($id)
    {
        // Fitur Warga: Membaca isi artikel penuh
        $edukasi = EdukasiDbd::findOrFail($id);
        return view('edukasi.show', compact('edukasi'));
    }

    // ==========================================
    // 2. AREA ADMIN (CRUD - HARUS LOGIN)
    // ==========================================

    public function index()
    {
        $edukasi = EdukasiDbd::latest()->get();
        return view('edukasi.index', compact('edukasi'));
    }

    public function create()
    {
        return view('edukasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'    => 'required|string|max:255',
            'konten'   => 'required|string',
            'kategori' => 'required|in:pencegahan,gejala,penanganan,fakta unik',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        $validated['admin_id'] = Auth::id();

        // Logika simpan gambar ke folder storage/app/public/edukasi_images
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('edukasi_images', 'public');
        }

        EdukasiDbd::create($validated);

        return redirect()->route('edukasi.index')->with('success', 'Materi edukasi berhasil dipublikasikan!');
    }

    // Untuk fungsi edit, update, dan destroy bisa menggunakan pola yang persis sama dengan CRUD Titik Risiko sebelumnya.
    public function destroy($id)
    {
        EdukasiDbd::findOrFail($id)->delete();
        return redirect()->route('edukasi.index')->with('success', 'Edukasi dihapus!');
    }
}