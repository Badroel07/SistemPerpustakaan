@extends('layouts.app')

@section('title', 'Pengembalian - Sistem Perpustakaan')
@section('page-title', 'Data Pengembalian')

@section('content')
<div class="card">
    <header class="card-header">
        <p class="card-header-title">
            <i class="fas fa-undo mr-2"></i> Daftar Pengembalian
        </p>
        <a href="{{ route('pengembalian.create') }}" class="button is-primary is-small m-3">
            <span class="icon"><i class="fas fa-plus"></i></span>
            <span>Pengembalian Baru</span>
        </a>
    </header>
    <div class="card-content">
        <!-- Search Form -->
        <form action="{{ route('pengembalian.index') }}" method="GET" class="mb-4">
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input class="input" type="text" name="search" placeholder="Cari ID pengembalian, nama anggota, atau judul buku..." value="{{ $search ?? '' }}">
                </div>
                <div class="control">
                    <button type="submit" class="button is-info">
                        <span class="icon"><i class="fas fa-search"></i></span>
                        <span>Cari</span>
                    </button>
                </div>
                @if($search ?? false)
                <div class="control">
                    <a href="{{ route('pengembalian.index') }}" class="button is-light">
                        <span class="icon"><i class="fas fa-times"></i></span>
                    </a>
                </div>
                @endif
            </div>
        </form>

        <table class="table is-fullwidth is-striped is-hoverable">
            <thead>
                <tr>
                    <th>ID Pengembalian</th>
                    <th>ID Peminjaman</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Kembali</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengembalian as $p)
                <tr>
                    <td>{{ $p->id_pengembalian }}</td>
                    <td>{{ $p->peminjaman->id_transaksi ?? '-' }}</td>
                    <td>{{ $p->peminjaman->anggota->nama ?? '-' }}</td>
                    <td>{{ $p->peminjaman->buku->judul ?? '-' }}</td>
                    <td>{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                    <td>
                        @if($p->denda > 0)
                        <span class="tag is-danger">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                        @else
                        <span class="tag is-success">Rp 0</span>
                        @endif
                    </td>
                    <td>
                        <div class="buttons are-small">
                            <a href="{{ route('pengembalian.show', $p->id_pengembalian) }}" class="button is-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('pengembalian.cetak', $p->id_pengembalian) }}" class="button is-light" target="_blank">
                                <i class="fas fa-print"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="has-text-centered" style="color: rgba(255,255,255,0.5); padding: 2rem;">
                        Belum ada data pengembalian
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $pengembalian->links('pagination::bulma') }}
        </div>
    </div>
</div>
@endsection