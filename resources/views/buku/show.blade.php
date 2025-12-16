@extends('layouts.app')

@section('title', 'Detail Buku - Sistem Perpustakaan')
@section('page-title', 'Detail Buku')

@section('content')
<div class="columns">
    <div class="column is-4">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <i class="fas fa-book mr-2"></i> Informasi Buku
                </p>
            </header>
            <div class="card-content">
                <div class="mb-4">
                    <p class="heading" style="color: rgba(255,255,255,0.5);">ID Buku</p>
                    <p class="title is-5" style="color: #f5f5f5;">{{ $buku->id_buku }}</p>
                </div>
                <div class="mb-4">
                    <p class="heading" style="color: rgba(255,255,255,0.5);">Judul</p>
                    <p class="title is-5" style="color: #f5f5f5;">{{ $buku->judul }}</p>
                </div>
                <div class="mb-4">
                    <p class="heading" style="color: rgba(255,255,255,0.5);">Pengarang</p>
                    <p style="color: rgba(255,255,255,0.8);">{{ $buku->pengarang ?? '-' }}</p>
                </div>
                <div class="mb-4">
                    <p class="heading" style="color: rgba(255,255,255,0.5);">Kategori</p>
                    <p style="color: rgba(255,255,255,0.8);">{{ $buku->kategori ?? '-' }}</p>
                </div>
                <div class="mb-4">
                    <p class="heading" style="color: rgba(255,255,255,0.5);">Status</p>
                    @if($buku->status === 'tersedia')
                    <span class="tag is-success is-medium">Tersedia</span>
                    @else
                    <span class="tag is-warning is-medium">Dipinjam</span>
                    @endif
                </div>

                <div class="buttons mt-5">
                    <a href="{{ route('buku.edit', $buku->id_buku) }}" class="button is-warning">
                        <span class="icon"><i class="fas fa-edit"></i></span>
                        <span>Edit</span>
                    </a>
                    <a href="{{ route('buku.index') }}" class="button is-light">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <div class="column is-8">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <i class="fas fa-history mr-2"></i> Riwayat Peminjaman
                </p>
            </header>
            <div class="card-content">
                @if($peminjaman->count() > 0)
                <table class="table is-fullwidth is-striped is-hoverable">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Anggota</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman as $p)
                        <tr>
                            <td>{{ $p->id_transaksi }}</td>
                            <td>{{ $p->anggota->nama ?? '-' }}</td>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="has-text-centered" style="color: rgba(255,255,255,0.5); padding: 2rem;">
                    Belum ada riwayat peminjaman
                </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection