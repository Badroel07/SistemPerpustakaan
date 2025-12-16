<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPeminjaman;
use App\Models\TransaksiPengembalian;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'semua');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Get all borrowings with related data
        $query = TransaksiPeminjaman::with(['anggota', 'buku', 'petugas', 'pengembalian']);

        // Apply date filter
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pinjam', [$startDate, $endDate]);
        }

        // Apply status filter
        if ($filter === 'dipinjam') {
            $query->whereDoesntHave('pengembalian');
        } elseif ($filter === 'dikembalikan') {
            $query->whereHas('pengembalian');
        } elseif ($filter === 'terlambat') {
            $query->whereDoesntHave('pengembalian')
                ->where('tanggal_jatuh_tempo', '<', now());
        }

        $laporan = $query->latest()->paginate(15);

        // Statistics
        $totalPeminjaman = TransaksiPeminjaman::count();
        $totalPengembalian = TransaksiPengembalian::count();
        $totalDenda = TransaksiPengembalian::sum('denda');
        $bukuDipinjam = TransaksiPeminjaman::whereDoesntHave('pengembalian')->count();

        return view('laporan.index', compact(
            'laporan',
            'filter',
            'startDate',
            'endDate',
            'totalPeminjaman',
            'totalPengembalian',
            'totalDenda',
            'bukuDipinjam'
        ));
    }
}
