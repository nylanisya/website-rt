<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $fillable = [
        'keluarga_id',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'status_dalam_keluarga',
        'pendidikan',
        'pekerjaan'
    ];

    // Relasi ke Keluarga
    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }
}