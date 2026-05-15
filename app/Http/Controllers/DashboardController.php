<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Warga;
use App\Models\Iuran;
use App\Models\Pengumuman;
use App\Models\JenisIuran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Kartu
        $totalKK = Keluarga::count();
        $totalWarga = Warga::count();
        $iuranLunas = Iuran::where('status', 'lunas')->count();
        $iuranBelum = Iuran::where('status', 'belum')->count();
        
        // Data untuk grafik iuran per bulan (6 bulan terakhir)
        $bulanLabels = [];
        $lunasData = [];
        $belumData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $bulanLabels[] = $bulan->format('M Y');
            
            $lunas = Iuran::where('status', 'lunas')
                ->whereYear('created_at', $bulan->year)
                ->whereMonth('created_at', $bulan->month)
                ->count();
            
            $belum = Iuran::where('status', 'belum')
                ->whereYear('created_at', $bulan->year)
                ->whereMonth('created_at', $bulan->month)
                ->count();
            
            $lunasData[] = $lunas;
            $belumData[] = $belum;
        }
        
        // Data untuk grafik jenis iuran
        $jenisIuran = JenisIuran::withCount(['iuran' => function($query) {
            $query->where('status', 'lunas');
        }])->get();
        
        $jenisLabels = $jenisIuran->pluck('nama');
        $jenisTotal = $jenisIuran->pluck('iuran_count');
        
        // Pengumuman terbaru
        $pengumumanTerbaru = Pengumuman::with('user')->latest()->take(5)->get();
        
        // Tagihan terbaru
        $tagihanTerbaru = Iuran::with('keluarga', 'jenisIuran')->latest()->take(5)->get();
        
        return view('dashboard', compact(
            'totalKK', 'totalWarga', 'iuranLunas', 'iuranBelum',
            'bulanLabels', 'lunasData', 'belumData',
            'jenisLabels', 'jenisTotal',
            'pengumumanTerbaru', 'tagihanTerbaru'
        ));
    }
}