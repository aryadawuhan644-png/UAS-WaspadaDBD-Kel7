<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $fillable = ['user_id', 'nama_petugas', 'nip', 'provinsi', 'kabupaten_kota', 'kecamatan'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}