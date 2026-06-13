<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan ini SANGAT PENTING. 
        // User dan Titik Risiko harus dibuat duluan karena Pemeriksaan butuh ID mereka.
        $this->call([
            UserSeeder::class,
            TitikRisikoSeeder::class,
            PemeriksaanRisikoSeeder::class, // <--- Tambahkan baris ini
        ]);
    }
}