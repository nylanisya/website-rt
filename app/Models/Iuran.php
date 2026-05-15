<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
   protected $fillable = [
    'keluarga_id', 
    'jenis_iuran_id', 
    'jenis_iuran_lainnya',
    'nominal',
    'tanggal_tagihan', 
    'tanggal_jatuh_tempo', 
    'status'
];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function jenisIuran()
    {
        return $this->belongsTo(JenisIuran::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}