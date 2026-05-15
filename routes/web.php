<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeluargaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\JenisIuranController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use App\Models\Pembayaran;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('jenis-iuran', JenisIuranController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('warga', WargaController::class);
    Route::resource('keluarga', KeluargaController::class);
    Route::prefix('laporan')->group(function () {
        Route::get('/warga', [LaporanController::class, 'warga'])->name(
            'laporan.warga',
        );
        Route::get('/iuran', [LaporanController::class, 'iuran'])->name(
            'laporan.iuran',
        );
        Route::get('/keuangan', [LaporanController::class, 'keuangan'])->name(
            'laporan.keuangan',
        );
    });

    // Route custom untuk Iuran (Tagihan)
    Route::prefix('iuran')->group(function () {
        Route::delete('/hapus-riwayat', [
            IuranController::class,
            'hapusRiwayat',
        ])->name('iuran.hapus-riwayat');
        Route::get('/batal/{id}', [IuranController::class, 'batalkan'])->name(
            'iuran.batal',
        );
        Route::get('/', [IuranController::class, 'index'])->name('iuran.index');
        Route::post('/store-tagihan', [
            IuranController::class,
            'storeTagihan',
        ])->name('iuran.store-tagihan');
        Route::get('/bayar/{id}', [IuranController::class, 'bayar'])->name(
            'iuran.bayar',
        );
        Route::post('/proses-bayar/{id}', [
            IuranController::class,
            'prosesBayar',
        ])->name('iuran.proses-bayar');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name(
        'profile.edit',
    );
    Route::patch('/profile', [ProfileController::class, 'update'])->name(
        'profile.update',
    );
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name(
        'profile.destroy',
    );
});

require __DIR__ . '/auth.php';
