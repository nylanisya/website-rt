<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Iuran;
use App\Models\Keluarga;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Laporan semua warga
    public function warga()
    {
        $wargas = Warga::with('keluarga')->get();
        $pdf = Pdf::loadView('laporan.warga', compact('wargas'));
        return $pdf->download('laporan-warga-rt.pdf');
    }

    // Laporan iuran per bulan
    public function iuran(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $iuran = Iuran::with('keluarga', 'jenisIuran', 'pembayaran')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get();

        $totalLunas = $iuran->where('status', 'lunas')->sum('nominal');
        $totalBelum = $iuran->where('status', 'belum')->sum('nominal');

        $pdf = Pdf::loadView(
            'laporan.iuran',
            compact('iuran', 'bulan', 'tahun', 'totalLunas', 'totalBelum'),
        );
        return $pdf->download(
            'laporan-iuran-' . $bulan . '-' . $tahun . '.pdf',
        );
    }

    // Laporan keuangan (semua pemasukan)
    public function keuangan()
    {
        $pembayaran = Pembayaran::with('iuran.keluarga', 'iuran.jenisIuran')
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        $totalPemasukan = $pembayaran->sum('jumlah_bayar');

        $pdf = Pdf::loadView(
            'laporan.keuangan',
            compact('pembayaran', 'totalPemasukan'),
        );
        return $pdf->download('laporan-keuangan-rt.pdf');
    }
}
