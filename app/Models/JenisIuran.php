<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisIuran extends Model
{
    protected $fillable = [
        'nama', 'nominal', 'periode'
    ];

    // Relasi ke Iuran
    public function iuran()
    {
        return $this->hasMany(Iuran::class);
    }
}