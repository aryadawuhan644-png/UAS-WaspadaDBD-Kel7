<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdukasiDbd extends Model
{
    protected $fillable = [
        'admin_id',
        'judul',
        'konten',
        'gambar',
        'kategori', // <-- Kategori ditambahkan di sini
    ];

    // Relasi ke Admin (User)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}