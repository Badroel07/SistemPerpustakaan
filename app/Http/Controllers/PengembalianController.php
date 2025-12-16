<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\TransaksiPeminjaman;
use App\Models\TransaksiPengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $pengembalian = TransaksiPengembalian::with(['peminjaman.anggota', 'peminjaman.buku'])
            ->when($search, function ($query, $search) {
                return $query->where('id_pengembalian', 'like', "%{$search}%")
                    ->orWhereHas('peminjaman', function ($q) use ($search) {
                        $q->where('id_transaksi', 'like', "%{$search}%");
                    })
                    ->orWhereHas('peminjaman.anggota', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('peminjaman.buku', function ($q) use ($search) {
                        $q->where('judul', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('pengembalian.index', compact('pengembalian', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get active borrowings (not yet returned)
        $peminjamanAktif = TransaksiPeminjaman::with(['anggota', 'buku'])
            ->whereDoesntHave('pengembalian')
            ->get();

        return view('pengembalian.create', compact('peminjamanAktif'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pengembalian' => 'required|string|max:20|unique:transaksi_pengembalian,id_pengembalian',
            'id_transaksi_peminjaman' => 'required|exists:transaksi_peminjaman,id_transaksi',
            'tanggal_kembali' => 'required|date',
        ]);

        // Get the borrowing transaction
        $peminjaman = TransaksiPeminjaman::findOrFail($validated['id_transaksi_peminjaman']);

        // Check if already returned
        if ($peminjaman->pengembalian) {
            return back()->withErrors(['id_transaksi_peminjaman' => 'Buku sudah dikembalikan.']);
        }

        // Calculate fine
        $denda = TransaksiPengembalian::calculateFine(
            $peminjaman->tanggal_jatuh_tempo,
            $validated['tanggal_kembali']
        );

        DB::transaction(function () use ($validated, $peminjaman, $denda) {
            // Create return transaction
            TransaksiPengembalian::create([
                'id_pengembalian' => $validated['id_pengembalian'],
                'id_transaksi_peminjaman' => $validated['id_transaksi_peminjaman'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'denda' => $denda,
            ]);

            // Update book status back to 'tersedia'
            $peminjaman->buku->update(['status' => 'tersedia']);
        });

        $message = 'Pengembalian berhasil dicatat!';
        if ($denda > 0) {
            $message .= ' Denda keterlambatan: Rp ' . number_format($denda, 0, ',', '.');
        }

        return redirect()->route('pengembalian.index')
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiPengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.anggota', 'peminjaman.buku', 'peminjaman.petugas']);
        return view('pengembalian.show', compact('pengembalian'));
    }

    /**
     * Generate next return ID.
     */
    public function generateId()
    {
        $lastPengembalian = TransaksiPengembalian::orderBy('id_pengembalian', 'desc')->first();

        if (!$lastPengembalian) {
            return response()->json(['id' => 'RTN001']);
        }

        $lastNumber = intval(substr($lastPengembalian->id_pengembalian, 3));
        $newNumber = $lastNumber + 1;

        return response()->json(['id' => 'RTN' . str_pad($newNumber, 3, '0', STR_PAD_LEFT)]);
    }

    /**
     * Calculate fine for a borrowing.
     */
    public function hitungDenda(Request $request)
    {
        $request->validate([
            'id_transaksi_peminjaman' => 'required|exists:transaksi_peminjaman,id_transaksi',
            'tanggal_kembali' => 'required|date',
        ]);

        $peminjaman = TransaksiPeminjaman::findOrFail($request->id_transaksi_peminjaman);
        $denda = TransaksiPengembalian::calculateFine(
            $peminjaman->tanggal_jatuh_tempo,
            $request->tanggal_kembali
        );

        return response()->json([
            'denda' => $denda,
            'denda_formatted' => 'Rp ' . number_format($denda, 0, ',', '.'),
            'is_late' => $denda > 0,
        ]);
    }

    /**
     * Print receipt for returning.
     */
    public function cetak(TransaksiPengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.anggota', 'peminjaman.buku', 'peminjaman.petugas']);
        return view('pengembalian.cetak', compact('pengembalian'));
    }
}
