<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Akun Admin
        User::create([
            'name' => 'Admin Waspada',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Membuat Akun Petugas
        User::create([
            'name' => 'Petugas Lapangan',
            'email' => 'petugas@demo.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
        ]);
    }
}