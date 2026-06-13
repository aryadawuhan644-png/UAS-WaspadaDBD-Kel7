<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PemeriksaanRisiko;

class PemeriksaanRisikoSeeder extends Seeder
{
    public function run(): void
    {
        PemeriksaanRisiko::create([
            'titik_risiko_id' => 1, // Pastikan titik risiko ID 1 sudah ada dari TitikRisikoSeeder
            'petugas_id' => 1,      // Pastikan user admin/petugas ID 1 sudah ada dari UserSeeder
            'tanggal_pemeriksaan' => now(),
            'ditemukan_jentik' => true,
            'kondisi_lingkungan' => 'Banyak kaleng bekas yang tergenang air hujan.',
            'tindakan_dilakukan' => 'Membersihkan genangan dan memberikan bubuk abate.',
            'status_akhir' => 'perlu tindakan',
        ]);
        
        // Kamu bisa menambahkan data pemeriksaan lainnya di sini
    }
}