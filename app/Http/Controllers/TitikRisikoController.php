<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TitikRisiko; // Tambahkan ini agar lebih rapi

class TitikRisikoController extends Controller
{
    public function index()
    {
        $titikRisikos = TitikRisiko::all();
        return view('titik_risiko.index', compact('titikRisikos'));
    }

    public function create()
    {
        return view('titik_risiko.create');
    }

    public function store(Request $request)
    {
        // Tambahkan validasi untuk rt_rw dan jenis_risiko
        $validated = $request->validate([
            'nama_titik'        => 'required|string|max:255',
            'alamat'            => 'required|string',
            'rt_rw'             => 'required|string|max:20',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'jenis_risiko'      => 'required|in:genangan,barang bekas,saluran air,tempat sampah',
            'level_risiko_awal' => 'required|in:rendah,sedang,tinggi',
        ]);

        // Pastikan status aktif tersimpan (checkbox)
        $validated['status_aktif'] = $request->has('status_aktif') ? true : true;

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
        // Sesuaikan validasi dengan store
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