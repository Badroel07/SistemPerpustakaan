@extends('layouts.app')

@section('title', 'Laporan - Sistem Perpustakaan')
@section('page-title', 'Laporan Transaksi')

@section('content')
<!-- Statistics Summary -->
<div class="columns is-multiline mb-5">
    <div class="column is-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #3273dc, #667eea);">
                <i class="fas fa-hand-holding" style="color: white;"></i>
            </div>
            <div class="stat-value">{{ $totalPeminjaman }}</div>
            <div class="stat-label">Total Peminjaman</div>
        </div>
    </div>
    <div class="column is-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #00d1b2, #20c997);">
                <i class="fas fa-undo" style="color: white;"></i>
            </div>
            <div class="stat-value">{{ $totalPengembalian }}</div>
            <div class="stat-label">Total Pengembalian</div>
        </div>
    </div>
    <div class="column is-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f39c12, #e74c3c);">
                <i class="fas fa-book" style="color: white;"></i>
            </div>
            <div class="stat-value">{{ $bukuDipinjam }}</div>
            <div class="stat-label">Masih Dipinjam</div>
        </div>
    </div>
    <div class="column is-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                <i class="fas fa-coins" style="color: white;"></i>
            </div>
            <div class="stat-value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
            <div class="stat-label">Total Denda</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-5">
    <div class="card-content">
        <form action="{{ route('laporan.index') }}" method="GET">
            <div class="columns is-vcentered">
                <div class="column is-3">
                    <div class="field">
                        <label class="label">Status</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="filter">
                                    <option value="semua" {{ $filter == 'semua' ? 'selected' : '' }}>Semua</option>
                                    <option value="dipinjam" {{ $filter == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="dikembalikan" {{ $filter == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                    <option value="terlambat" {{ $filter == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <label class="label">Dari Tanggal</label>
                        <div class="control">
                            <input class="input" type="date" name="start_date" value="{{ $startDate }}">
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <label class="label">Sampai Tanggal</label>
                        <div class="control">
                            <input class="input" type="date" name="end_date" value="{{ $endDate }}">
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <label class="label">&nbsp;</label>
                        <div class="control">
                            <button type="submit" class="button is-primary is-fullwidth">
                                <span class="icon"><i class="fas fa-filter"></i></span>
                                <span>Filter</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <header class="card-header">
        <p class="card-header-title">
            <i class="fas fa-table mr-2"></i> Data Transaksi
        </p>
    </header>
    <div class="card-content">
        <table class="table is-fullwidth is-striped is-hoverable">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Tgl Kembali</th>
                    <th>Denda</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $l)
                <tr>
                    <td>{{ $l->id_transaksi }}</td>
                    <td>{{ $l->anggota->nama ?? '-' }}</td>
                    <td>{{ $l->buku->judul ?? '-' }}</td>
                    <td>{{ $l->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td>{{ $l->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                    <td>{{ $l->pengembalian ? $l->pengembalian->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                    <td>
                        @if($l->pengembalian && $l->pengembalian->denda > 0)
                        <span class="has-text-danger">Rp {{ number_format($l->pengembalian->denda, 0, ',', '.') }}</span>
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if($l->pengembalian)
                        <span class="tag is-success">Dikembalikan</span>
                        @elseif($l->isOverdue())
                        <span class="tag is-danger">Terlambat</span>
                        @else
                        <span class="tag is-warning">Dipinjam</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="has-text-centered" style="color: rgba(255,255,255,0.5); padding: 2rem;">
                        Tidak ada data transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $laporan->appends(request()->query())->links('pagination::bulma') }}
        </div>
    </div>
</div>
@endsection