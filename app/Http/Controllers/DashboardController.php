<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\TransaksiPeminjaman;
use App\Models\TransaksiPengembalian;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::count();
        $bukuTersedia = Buku::where('status', 'tersedia')->count();
        $bukuDipinjam = Buku::where('status', 'dipinjam')->count();

        // Active borrowings (not yet returned)
        $peminjamanAktif = TransaksiPeminjaman::whereDoesntHave('pengembalian')->count();

        // Overdue borrowings
        $peminjamanTerlambat = TransaksiPeminjaman::whereDoesntHave('pengembalian')
            ->where('tanggal_jatuh_tempo', '<', now())
            ->count();

        // Recent transactions
        $recentPeminjaman = TransaksiPeminjaman::with(['anggota', 'buku', 'petugas'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'bukuTersedia',
            'bukuDipinjam',
            'peminjamanAktif',
            'peminjamanTerlambat',
            'recentPeminjaman'
        ));
    }
}
