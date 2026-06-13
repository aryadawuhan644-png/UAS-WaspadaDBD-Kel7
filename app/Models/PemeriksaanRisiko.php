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
        'kondisi_lingkungan',
        'tindakan_dilakukan',
        'status_akhir',
    ];

    protected $casts = [
        'ditemukan_jentik' => 'boolean',
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
}