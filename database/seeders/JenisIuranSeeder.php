<?php

namespace Database\Seeders;

use App\Models\JenisIuran;
use Illuminate\Database\Seeder;

class JenisIuranSeeder extends Seeder
{
    public function run()
    {
        $jenis = [
            ['nama' => 'Keamanan', 'nominal' => 30000, 'periode' => 'bulanan'],
            ['nama' => 'Kebersihan', 'nominal' => 20000, 'periode' => 'bulanan'],
            ['nama' => 'Kas Sosial', 'nominal' => 15000, 'periode' => 'bulanan'],
            ['nama' => 'Badan Sosial Kematian (BSK)', 'nominal' => 10000, 'periode' => 'bulanan'],
            ['nama' => 'Kegiatan Warga', 'nominal' => 10000, 'periode' => 'bulanan'],
        ];

        foreach ($jenis as $j) {
            JenisIuran::create($j);
        }
    }
}