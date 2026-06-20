<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TitikRisiko;
use App\Models\User;

class PemeriksaanRisiko extends Model
{
    use HasFactory;

    protected $fillable = [
        'titik_risiko_id',
        'petugas_id',
        'tanggal_pemeriksaan',
        'ditemukan_jentik',
        'ada_wadah', // Ditambahkan di sini agar bisa diisi
        'kondisi_lingkungan',
        'tindakan_dilakukan',
        'status_akhir',
        'foto',
    ];

    protected $casts = [
        'ditemukan_jentik' => 'boolean',
        'ada_wadah' => 'boolean', // Ditambahkan agar otomatis jadi boolean
        'tanggal_pemeriksaan' => 'date',
        'petugas_id' => 'integer',
    ];

    /**
     * Relasi ke model TitikRisiko.
     */
    public function titikRisiko()
    {
        return $this->belongsTo(TitikRisiko::class);
    }

    /**
     * Relasi ke model User (petugas).
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function getSkorRisikoAttribute()
    {
        $skor = 0;
        if ($this->ditemukan_jentik) $skor += 50;
        if ($this->ada_wadah) $skor += 30;
        if ($this->kondisi_lingkungan === 'kotor') $skor += 20;
        
        return $skor;
    }

    public function getWarnaRisikoAttribute()
    {
        $skor = $this->skor_risiko;
        if ($skor == 0) return 'green';
        if ($skor <= 50) return 'yellow';
        return 'red';
    }
    public function getLevelRisikoAttribute()
{
    $skor = $this->skor_risiko;
    if ($skor == 0) return 'Rendah';
    if ($skor <= 50) return 'Sedang';
    return 'Tinggi';
}
}