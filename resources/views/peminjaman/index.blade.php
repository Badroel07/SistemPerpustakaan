@extends('layouts.app')

@section('title', 'Peminjaman - Sistem Perpustakaan')
@section('page-title', 'Data Peminjaman')

@section('content')
<div class="card">
    <header class="card-header">
        <p class="card-header-title">
            <i class="fas fa-hand-holding mr-2"></i> Daftar Peminjaman
        </p>
        <a href="{{ route('peminjaman.create') }}" class="button is-primary is-small m-3">
            <span class="icon"><i class="fas fa-plus"></i></span>
            <span>Peminjaman Baru</span>
        </a>
    </header>
    <div class="card-content">
        <!-- Search Form -->
        <form action="{{ route('peminjaman.index') }}" method="GET" class="mb-4">
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input class="input" type="text" name="search" placeholder="Cari ID transaksi, nama anggota, atau judul buku..." value="{{ $search ?? '' }}">
                </div>
                <div class="control">
                    <button type="submit" class="button is-info">
                        <span class="icon"><i class="fas fa-search"></i></span>
                        <span>Cari</span>
                    </button>
                </div>
                @if($search ?? false)
                <div class="control">
                    <a href="{{ route('peminjaman.index') }}" class="button is-light">
                        <span class="icon"><i class="fas fa-times"></i></span>
                    </a>
                </div>
                @endif
            </div>
        </form>

        <table class="table is-fullwidth is-striped is-hoverable">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $p)
                <tr>
                    <td>{{ $p->id_transaksi }}</td>
                    <td>{{ $p->anggota->nama ?? '-' }}</td>
                    <td>{{ $p->buku->judul ?? '-' }}</td>
                    <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td>{{ $p->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                    <td>
                        @if($p->pengembalian)
                        <span class="tag is-success">Dikembalikan</span>
                        @elseif($p->isOverdue())
                        <span class="tag is-danger">Terlambat</span>
                        @else
                        <span class="tag is-warning">Dipinjam</span>
                        @endif
                    </td>
                    <td>
                        <div class="buttons are-small">
                            <a href="{{ route('peminjaman.show', $p->id_transaksi) }}" class="button is-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('peminjaman.cetak', $p->id_transaksi) }}" class="button is-light" target="_blank">
                                <i class="fas fa-print"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="has-text-centered" style="color: rgba(255,255,255,0.5); padding: 2rem;">
                        Belum ada data peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $peminjaman->links('pagination::bulma') }}
        </div>
    </div>
</div>
@endsection