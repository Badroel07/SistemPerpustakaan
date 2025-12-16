@extends('layouts.app')

@section('title', 'Dashboard - Sistem Perpustakaan')
@section('page-title', 'Dashboard')

@section('content')
<div class="columns is-multiline">
    <!-- Stats Cards -->
    <div class="column is-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #3273dc, #667eea);">
                <i class="fas fa-book" style="color: white;"></i>
            </div>
            <div class="stat-value">{{ $totalBuku }}</div>
            <div class="stat-label">Total Buku</div>
        </div>
    </div>

    <div class="column is-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #00d1b2, #20c997);">
                <i class="fas fa-users" style="color: white;"></i>
            </div>
            <div class="stat-value">{{ $totalAnggota }}</div>
            <div class="stat-label">Total Anggota</div>
        </div>
    </div>

    <div class="column is-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f39c12, #e74c3c);">
                <i class="fas fa-hand-holding" style="color: white;"></i>
            </div>
            <div class="stat-value">{{ $peminjamanAktif }}</div>
            <div class="stat-label">Buku Dipinjam</div>
        </div>
    </div>

    <div class="column is-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                <i class="fas fa-exclamation-triangle" style="color: white;"></i>
            </div>
            <div class="stat-value">{{ $peminjamanTerlambat }}</div>
            <div class="stat-label">Terlambat</div>
        </div>
    </div>
</div>

<div class="columns">
    <!-- Quick Actions -->
    <div class="column is-4">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <i class="fas fa-bolt mr-2"></i> Aksi Cepat
                </p>
            </header>
            <div class="card-content">
                <div class="quick-action-buttons">
                    <a href="{{ route('peminjaman.create') }}" class="button is-primary is-fullwidth mb-3" style="justify-content: flex-start; height: 48px;">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span>Peminjaman Baru</span>
                    </a>
                    <a href="{{ route('pengembalian.create') }}" class="button is-info is-fullwidth mb-3" style="justify-content: flex-start; height: 48px;">
                        <span class="icon"><i class="fas fa-undo"></i></span>
                        <span>Pengembalian Buku</span>
                    </a>
                    <a href="{{ route('anggota.create') }}" class="button is-success is-fullwidth mb-3" style="justify-content: flex-start; height: 48px;">
                        <span class="icon"><i class="fas fa-user-plus"></i></span>
                        <span>Tambah Anggota</span>
                    </a>
                    <a href="{{ route('buku.create') }}" class="button is-warning is-fullwidth" style="justify-content: flex-start; height: 48px;">
                        <span class="icon"><i class="fas fa-book-medical"></i></span>
                        <span>Tambah Buku</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="column is-8">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <i class="fas fa-clock mr-2"></i> Transaksi Terbaru
                </p>
                <a href="{{ route('peminjaman.index') }}" class="card-header-icon" style="color: #00d1b2;">
                    Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </header>
            <div class="card-content">
                @if($recentPeminjaman->count() > 0)
                <table class="table is-fullwidth is-hoverable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPeminjaman as $pinjam)
                        <tr>
                            <td>{{ $pinjam->id_transaksi }}</td>
                            <td>{{ $pinjam->anggota->nama ?? '-' }}</td>
                            <td>{{ $pinjam->buku->judul ?? '-' }}</td>
                            <td>{{ $pinjam->tanggal_pinjam->format('d/m/Y') }}</td>
                            <td>
                                @if($pinjam->pengembalian)
                                <span class="tag is-success">Dikembalikan</span>
                                @elseif($pinjam->isOverdue())
                                <span class="tag is-danger">Terlambat</span>
                                @else
                                <span class="tag is-warning">Dipinjam</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="has-text-centered" style="color: rgba(255,255,255,0.5); padding: 2rem;">
                    <i class="fas fa-inbox fa-2x mb-3" style="display: block;"></i>
                    Belum ada transaksi
                </p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Book Availability Summary -->
<div class="columns mt-4">
    <div class="column">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <i class="fas fa-chart-pie mr-2"></i> Ketersediaan Buku
                </p>
            </header>
            <div class="card-content">
                <div class="columns is-vcentered">
                    <div class="column is-6">
                        <div class="is-flex is-align-items-center mb-4">
                            <span class="tag is-success is-large mr-3">{{ $bukuTersedia }}</span>
                            <span style="color: rgba(255,255,255,0.8);">Buku Tersedia</span>
                        </div>
                        <div class="is-flex is-align-items-center">
                            <span class="tag is-warning is-large mr-3">{{ $bukuDipinjam }}</span>
                            <span style="color: rgba(255,255,255,0.8);">Buku Dipinjam</span>
                        </div>
                    </div>
                    <div class="column is-6">
                        <progress class="progress is-success" value="{{ $bukuTersedia }}" max="{{ $totalBuku }}">
                            {{ $totalBuku > 0 ? round(($bukuTersedia / $totalBuku) * 100) : 0 }}%
                        </progress>
                        <p class="has-text-centered" style="color: rgba(255,255,255,0.6); font-size: 0.9rem;">
                            {{ $totalBuku > 0 ? round(($bukuTersedia / $totalBuku) * 100) : 0 }}% buku tersedia
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection