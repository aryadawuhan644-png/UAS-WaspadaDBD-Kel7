<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitikRisiko extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_titik',
        'alamat',
        'rt_rw',
        'latitude',
        'longitude',
        'jenis_risiko',
        'level_risiko_awal',
        'status_aktif',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'status_aktif' => 'boolean',
    ];

    public function pemeriksaan()
    {
        return $this->hasMany(PemeriksaanRisiko::class, 'titik_risiko_id');
    }
}