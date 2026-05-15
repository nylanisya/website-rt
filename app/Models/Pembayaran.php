<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'iuran_id', 'tanggal_bayar', 'jumlah_bayar', 'metode', 'bukti', 'keterangan'
    ];

    public function iuran()
    {
        return $this->belongsTo(Iuran::class);
    }
}