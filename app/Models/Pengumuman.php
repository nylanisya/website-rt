<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $fillable = [
        'judul',
        'isi',
        'tanggal_terbit',
        'user_id'
    ];

    // Relasi ke User (pembuat pengumuman)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}