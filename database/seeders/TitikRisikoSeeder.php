<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TitikRisiko;

class TitikRisikoSeeder extends Seeder
{
    public function run(): void
    {
        TitikRisiko::create([
            'nama_titik' => 'Genangan Lahan Kosong',
            'alamat' => 'Jl. S. Supriadi, Sukun',
            'rt_rw' => 'RT 01/RW 02',
            'latitude' => -7.994230,
            'longitude' => 112.620010,
            'jenis_risiko' => 'genangan',
            'level_risiko_awal' => 'tinggi',
            'status_aktif' => true,
        ]);

        TitikRisiko::create([
            'nama_titik' => 'Tumpukan Ban Bekas',
            'alamat' => 'Jl. MT Haryono, Lowokwaru',
            'rt_rw' => 'RT 03/RW 05',
            'latitude' => -7.943010,
            'longitude' => 112.614050,
            'jenis_risiko' => 'barang bekas',
            'level_risiko_awal' => 'sedang',
            'status_aktif' => true,
        ]);
    }
}