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
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'rt_rw',
        'latitude',
        'longitude',
        'jenis_risiko',
        'level_risiko_awal',
        'status_aktif',
        'foto_awal', // Menambahkan kolom foto_awal ke dalam fillable
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

    /**
     * Scope untuk mengambil titik risiko yang dianggap 'tinggi'.
     * Definisi: level_risiko_awal == 'tinggi' OR punya pemeriksaan dengan status 'perlu tindakan'.
     */
    public function scopeHighRisk($query)
    {
        return $query->where('level_risiko_awal', 'tinggi')
                     ->orWhereHas('pemeriksaan', function ($q) {
                         $q->where('status_akhir', 'perlu tindakan');
                     });
    }

    

}