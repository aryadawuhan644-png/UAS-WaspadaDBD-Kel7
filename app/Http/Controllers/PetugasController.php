<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;
use App\Models\User;
use Laravolt\Indonesia\Models\Province;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function index()
    {
        $users = User::all(); 
        return view('petugas.index', compact('users'));
    }

    public function create() 
    {
        $provinces = Province::all();
        return view('petugas.create', compact('provinces'));
    }

    public function store(Request $request) 
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,petugas',
        ];

        if ($request->role === 'petugas') {
            $rules['provinsi'] = 'required';
            $rules['kabupaten_kota'] = 'required';
            $rules['kecamatan'] = 'required';
        }

        $request->validate($rules);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role, 
            ]);

            if ($request->role === 'petugas') {
                Petugas::create([
                    'user_id'       => $user->id,
                    'nama_petugas'  => $request->name,
                    'provinsi'      => $request->provinsi,
                    'kabupaten_kota'=> $request->kabupaten_kota,
                    'kecamatan'     => $request->kecamatan,
                ]);
            }
        });

        return redirect()->route('petugas.index')->with('success', 'Akun berhasil dibuat!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $petugas = Petugas::where('user_id', $user->id)->first();
        $provinces = Province::all();
        return view('petugas.edit', compact('user', 'petugas', 'provinces'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id, // Mengizinkan email tetap sama
            'role'     => 'required|in:admin,petugas',
            'password' => 'nullable|min:8',
        ]);

        DB::transaction(function () use ($request, $user) {
            // Siapkan data update
            $userData = [
                'name'  => $request->name, 
                'email' => $request->email, // Update email
                'role'  => $request->role
            ];

            // Jika ada password baru, tambahkan ke array update
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            if ($request->role === 'petugas') {
                Petugas::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama_petugas'  => $request->name,
                        'provinsi'      => $request->provinsi,
                        'kabupaten_kota'=> $request->kabupaten_kota,
                        'kecamatan'     => $request->kecamatan,
                    ]
                );
            } else {
                Petugas::where('user_id', $user->id)->delete();
            }
        });

        return redirect()->route('petugas.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Petugas::where('user_id', $user->id)->delete();
        $user->delete();

        return redirect()->route('petugas.index')->with('success', 'Akun berhasil dihapus!');
    }
}