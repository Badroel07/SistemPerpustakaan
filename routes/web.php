<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LaporanController;
use App\Http\Middleware\AuthenticatePetugas;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware([AuthenticatePetugas::class])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Data Master - Anggota
    Route::resource('anggota', AnggotaController::class);

    // Data Master - Buku
    Route::resource('buku', BukuController::class);

    // Transaksi - Peminjaman
    Route::get('/peminjaman/generate-id', [PeminjamanController::class, 'generateId'])->name('peminjaman.generate-id');
    Route::get('/peminjaman/{peminjaman}/cetak', [PeminjamanController::class, 'cetak'])->name('peminjaman.cetak');
    Route::resource('peminjaman', PeminjamanController::class)->except(['edit', 'update', 'destroy']);

    // Transaksi - Pengembalian
    Route::get('/pengembalian/generate-id', [PengembalianController::class, 'generateId'])->name('pengembalian.generate-id');
    Route::post('/pengembalian/hitung-denda', [PengembalianController::class, 'hitungDenda'])->name('pengembalian.hitung-denda');
    Route::get('/pengembalian/{pengembalian}/cetak', [PengembalianController::class, 'cetak'])->name('pengembalian.cetak');
    Route::resource('pengembalian', PengembalianController::class)->except(['edit', 'update', 'destroy']);

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});
