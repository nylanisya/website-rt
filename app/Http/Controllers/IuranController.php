<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\Keluarga;
use App\Models\JenisIuran;
use Illuminate\Http\Request;

class IuranController extends Controller
{
    public function index(Request $request)
    {
        $jenisIurans = JenisIuran::all();

        // Query tagihan
        $query = Iuran::with('keluarga', 'jenisIuran');

        // Filter by jenis iuran
        if ($request->filled('jenis_iuran')) {
            $query->where('jenis_iuran_id', $request->jenis_iuran);
        }

        // Search by No KK atau Kepala Keluarga
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('keluarga', function ($q) use ($search) {
                $q->where('no_kk', 'like', "%{$search}%")->orWhere(
                    'kepala_keluarga',
                    'like',
                    "%{$search}%",
                );
            });
        }

        $tagihan = $query->latest()->get();

        return view('iuran.tagihan', compact('jenisIurans', 'tagihan'));
    }
    public function hapusRiwayat(Request $request)
    {
        $type = $request->type;

        if ($type == 'semua') {
            // Hapus semua tagihan
            Iuran::truncate();
            \App\Models\Pembayaran::truncate(); // pakai namespace lengkap
            $message = 'Semua riwayat tagihan dan pembayaran berhasil dihapus';
        } elseif ($type == 'lunas') {
            // Hapus hanya tagihan yang sudah lunas
            $iuranLunas = Iuran::where('status', 'lunas')->get();
            foreach ($iuranLunas as $iuran) {
                if ($iuran->pembayaran) {
                    $iuran->pembayaran->delete();
                }
                $iuran->delete();
            }
            $message = 'Riwayat tagihan yang sudah lunas berhasil dihapus';
        } else {
            return redirect()->back()->with('error', 'Pilihan tidak valid');
        }

        return redirect()->route('iuran.index')->with('success', $message);
    }
    public function storeTagihan(Request $request)
    {
        $request->validate([
            'jenis_iuran_id' => 'required',
            'nominal' => 'required|numeric',
            'tanggal_tagihan' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        $jenis_iuran_id = $request->jenis_iuran_id;
        $jenis_iuran_lainnya = null;

        // Jika pilih "Lainnya"
        if ($request->jenis_iuran_id == 'lainnya') {
            // Buat jenis iuran baru
            $jenisBaru = JenisIuran::create([
                'nama' => $request->nama_lainnya,
                'nominal' => str_replace('.', '', $request->nominal),
                'periode' => 'sekali',
            ]);
            $jenis_iuran_id = $jenisBaru->id;
            $jenis_iuran_lainnya = $request->nama_lainnya;
        }

        // Ambil semua KK
        $keluargas = Keluarga::all();

        foreach ($keluargas as $keluarga) {
            Iuran::create([
                'keluarga_id' => $keluarga->id,
                'jenis_iuran_id' => $jenis_iuran_id,
                'jenis_iuran_lainnya' => $jenis_iuran_lainnya,
                'nominal' => $request->nominal,
                'tanggal_tagihan' => $request->tanggal_tagihan,
                'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                'status' => 'belum',
            ]);
        }

        return redirect()
            ->route('iuran.index')
            ->with('success', 'Tagihan berhasil dibuat untuk semua KK');
    }

    public function bayar($id)
    {
        $tagihan = Iuran::findOrFail($id);
        return view('iuran.bayar', compact('tagihan'));
    }

    public function prosesBayar(Request $request, $id)
    {
        $tagihan = Iuran::findOrFail($id);

        // Update status iuran
        $tagihan->update([
            'status' => 'lunas',
        ]);

        // Catat pembayaran
        \App\Models\Pembayaran::create([
            'iuran_id' => $tagihan->id,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah_bayar' => $tagihan->nominal,
            'metode' => $request->metode,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('iuran.index')
            ->with('success', 'Pembayaran berhasil dicatat');
    }
    public function batalkan($id)
    {
        $tagihan = Iuran::findOrFail($id);

        // Update status kembali ke 'belum'
        $tagihan->update([
            'status' => 'belum',
        ]);

        // Hapus data pembayaran jika ada
        if ($tagihan->pembayaran) {
            $tagihan->pembayaran->delete();
        }

        return redirect()
            ->route('iuran.index')
            ->with('success', 'Pembayaran dibatalkan, status kembali ke BELUM');
    }
}
