<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\TransaksiPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $peminjaman = TransaksiPeminjaman::with(['anggota', 'buku', 'petugas', 'pengembalian'])
            ->when($search, function ($query, $search) {
                return $query->where('id_transaksi', 'like', "%{$search}%")
                    ->orWhereHas('anggota', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('buku', function ($q) use ($search) {
                        $q->where('judul', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('peminjaman.index', compact('peminjaman', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggota = Anggota::all();
        $buku = Buku::where('status', 'tersedia')->get();

        return view('peminjaman.create', compact('anggota', 'buku'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_transaksi' => 'required|string|max:20|unique:transaksi_peminjaman,id_transaksi',
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_buku' => 'required|exists:buku,id_buku',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // Check if book is available
        $buku = Buku::find($validated['id_buku']);
        if ($buku->status !== 'tersedia') {
            return back()->withErrors(['id_buku' => 'Buku tidak tersedia untuk dipinjam.']);
        }

        DB::transaction(function () use ($validated, $buku) {
            // Create borrowing transaction
            TransaksiPeminjaman::create([
                'id_transaksi' => $validated['id_transaksi'],
                'id_anggota' => $validated['id_anggota'],
                'id_petugas' => Auth::guard('petugas')->user()->id_petugas,
                'id_buku' => $validated['id_buku'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'],
            ]);

            // Update book status to 'dipinjam'
            $buku->update(['status' => 'dipinjam']);
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dicatat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiPeminjaman $peminjaman)
    {
        $peminjaman->load(['anggota', 'buku', 'petugas', 'pengembalian']);
        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Generate next transaction ID.
     */
    public function generateId()
    {
        $lastPeminjaman = TransaksiPeminjaman::orderBy('id_transaksi', 'desc')->first();

        if (!$lastPeminjaman) {
            return response()->json(['id' => 'TRX001']);
        }

        $lastNumber = intval(substr($lastPeminjaman->id_transaksi, 3));
        $newNumber = $lastNumber + 1;

        return response()->json(['id' => 'TRX' . str_pad($newNumber, 3, '0', STR_PAD_LEFT)]);
    }

    /**
     * Print receipt for borrowing.
     */
    public function cetak(TransaksiPeminjaman $peminjaman)
    {
        $peminjaman->load(['anggota', 'buku', 'petugas']);
        return view('peminjaman.cetak', compact('peminjaman'));
    }
}
