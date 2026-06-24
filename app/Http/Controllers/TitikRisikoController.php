<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TitikRisiko;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;

class TitikRisikoController extends Controller
{
    public function index(Request $request)
    {
        $query = TitikRisiko::query();
        $petugas = \App\Models\Petugas::where('user_id', auth()->id())->first();

        if ($petugas) {
            $query->where('kecamatan', $petugas->kecamatan);
        }

        if ($request->filled('level')) {
            $query->where('level_risiko_awal', $request->level);
        }

        if ($request->filled('wilayah')) {
            $query->where(function($q) use ($request) {
                $q->where('rt_rw', 'like', '%' . $request->wilayah . '%')
                  ->orWhere('nama_titik', 'like', '%' . $request->wilayah . '%');
            });
        }

        $titikRisikos = $query->latest()->latest()->get();
        return view('titik_risiko.index', compact('titikRisikos'));
    }

    public function jumlah()
    {
        $titik_risikos = TitikRisiko::latest()->get();
        return view('titik_risiko.jumlah', compact('titik_risikos'));
    }

    public function create()
    {
        $provinces = Province::all();
        return view('titik_risiko.create', compact('provinces'));
    }

    public function store(Request $request)
    {

        $request->merge([
            'status_aktif' => ($request->status_aktif == '1' || $request->status_aktif == 'on') ? true : false
        ]);

        $validated = $request->validate([
            'nama_titik'        => 'required|string|max:255',
            'provinsi'          => 'required',
            'kabupaten_kota'    => 'required',
            'kecamatan'         => 'required',
            'alamat'            => 'required',
            'rt_rw'             => 'required|string|max:20',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'jenis_risiko'      => 'required|in:genangan,barang bekas,saluran air,tempat sampah',
            'level_risiko_awal' => 'required|in:rendah,sedang,tinggi',
            'status_aktif'      => 'boolean',
            'foto_awal'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Mapping dengan fallback ke inputan langsung jika ID tidak ditemukan di Laravolt
        $validated['provinsi']       = Province::find($request->provinsi)?->name ?? $request->provinsi;
        $validated['kabupaten_kota'] = City::find($request->kabupaten_kota)?->name ?? $request->kabupaten_kota;
        $validated['kecamatan']      = District::find($request->kecamatan)?->name ?? $request->kecamatan;


        if ($request->hasFile('foto_awal')) {
    $file = $request->file('foto_awal');
    $filename = time().'_'.$file->getClientOriginalName();
    $file->move(public_path('foto_awal'), $filename);
    $validated['foto_awal'] = $filename;
}
        TitikRisiko::create($validated);
        return redirect()->route('titik-risiko.jumlah')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(string $id)
{
    // 1. Ambil data titik risiko yang mau diedit
    $titik = \App\Models\TitikRisiko::findOrFail($id); 
    
    // 2. Ambil semua data provinsi untuk dropdown
    $provinces = \Laravolt\Indonesia\Models\Province::all();

    // 3. Cari object provinsi saat ini berdasarkan nama provinsi yang tersimpan di database
    $currentProvinsi = \Laravolt\Indonesia\Models\Province::where('name', $titik->provinsi)->first();

    // CATATAN: Jika ternyata di database Anda menyimpan ID (angka), bukan Nama, gunakan kode ini:
    // $currentProvinsi = \Laravolt\Indonesia\Models\Province::find($titik->provinsi);

    // 4. Pastikan $currentProvinsi dimasukkan ke dalam compact()
    return view('titik_risiko.edit', compact('titik', 'provinces', 'currentProvinsi'));
}

    public function update(Request $request, string $id)
    {
        $titik = TitikRisiko::findOrFail($id);

        $request->merge([
            'status_aktif' => ($request->status_aktif == '1' || $request->status_aktif == 'on') ? true : false
        ]);

        $validated = $request->validate([
            'nama_titik'        => 'required|string|max:255',
            'provinsi'          => 'required',
            'kabupaten_kota'    => 'required',
            'kecamatan'         => 'required',
            'alamat'            => 'required|string',
            'rt_rw'             => 'required|string|max:20',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'jenis_risiko'      => 'required|in:genangan,barang bekas,saluran air,tempat sampah',
            'level_risiko_awal' => 'required|in:rendah,sedang,tinggi',
            'status_aktif'      => 'boolean',
            'foto_awal'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Mapping dengan fallback ke inputan langsung
        $validated['provinsi']       = Province::find($request->provinsi)?->name ?? $request->provinsi;
        $validated['kabupaten_kota'] = City::find($request->kabupaten_kota)?->name ?? $request->kabupaten_kota;
        $validated['kecamatan']      = District::find($request->kecamatan)?->name ?? $request->kecamatan;

        if ($request->hasFile('foto_awal')) {
    $file = $request->file('foto_awal');
    $filename = time().'_'.$file->getClientOriginalName();
    $file->move(public_path('foto_awal'), $filename);
    $validated['foto_awal'] = $filename;
}

        $titik->update($validated);
        
        return redirect()->route('titik-risiko.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        TitikRisiko::findOrFail($id)->delete();
        return redirect()->route('titik-risiko.index')->with('success', 'Data berhasil dihapus!');
    }
}