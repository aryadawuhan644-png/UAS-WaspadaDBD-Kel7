<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitikRisiko extends Model
{
    protected $fillable = [
        'nama_titik', 'alamat', 'rt_rw', 'latitude', 'longitude', 'jenis_risiko', 'level_risiko_awal', 'status_aktif'
    ];
}