@extends('layouts.app')

@section('title', 'Detail Peminjaman - Sistem Perpustakaan')
@section('page-title', 'Detail Peminjaman')

@section('content')
<div class="columns">
    <div class="column is-6">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <i class="fas fa-info-circle mr-2"></i> Informasi Peminjaman
                </p>
            </header>
            <div class="card-content">
                <table class="table is-fullwidth" style="background: transparent;">
                    <tr>
                        <td style="color: rgba(255,255,255,0.5); width: 40%;">ID Transaksi</td>
                        <td style="color: #f5f5f5; font-weight: 600;">{{ $peminjaman->id_transaksi }}</td>
                    </tr>
                    <tr>
                        <td style="color: rgba(255,255,255,0.5);">Status</td>
                        <td>
                            @if($peminjaman->pengembalian)
                            <span class="tag is-success is-medium">Dikembalikan</span>
                            @elseif($peminjaman->isOverdue())
                            <span class="tag is-danger is-medium">Terlambat</span>
                            @else
                            <span class="tag is-warning is-medium">Dipinjam</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="color: rgba(255,255,255,0.5);">Tanggal Pinjam</td>
                        <td style="color: #f5f5f5;">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="color: rgba(255,255,255,0.5);">Jatuh Tempo</td>
                        <td style="color: #f5f5f5;">{{ $peminjaman->tanggal_jatuh_tempo->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="color: rgba(255,255,255,0.5);">Petugas</td>
                        <td style="color: #f5f5f5;">{{ $peminjaman->petugas->nama ?? '-' }}</td>
                    </tr>
                </table>

                <div class="buttons mt-5">
                    <a href="{{ route('peminjaman.cetak', $peminjaman->id_transaksi) }}" class="button is-info" target="_blank">
                        <span class="icon"><i class="fas fa-print"></i></span>
                        <span>Cetak Struk</span>
                    </a>
                    @if(!$peminjaman->pengembalian)
                    <a href="{{ route('pengembalian.create') }}" class="button is-success">
                        <span class="icon"><i class="fas fa-undo"></i></span>
                        <span>Proses Pengembalian</span>
                    </a>
                    @endif
                    <a href="{{ route('peminjaman.index') }}" class="button is-light">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <div class="column is-3">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <i class="fas fa-user mr-2"></i> Anggota
                </p>
            </header>
            <div class="card-content">
                <p class="title is-5" style="color: #f5f5f5;">{{ $peminjaman->anggota->nama ?? '-' }}</p>
                <p style="color: rgba(255,255,255,0.6);">{{ $peminjaman->anggota->id_anggota ?? '-' }}</p>
                <p style="color: rgba(255,255,255,0.6); margin-top: 0.5rem;">
                    <i class="fas fa-phone mr-1"></i> {{ $peminjaman->anggota->no_hp ?? '-' }}
                </p>
            </div>
        </div>
    </div>

    <div class="column is-3">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <i class="fas fa-book mr-2"></i> Buku
                </p>
            </header>
            <div class="card-content">
                <p class="title is-5" style="color: #f5f5f5;">{{ $peminjaman->buku->judul ?? '-' }}</p>
                <p style="color: rgba(255,255,255,0.6);">{{ $peminjaman->buku->id_buku ?? '-' }}</p>
                <p style="color: rgba(255,255,255,0.6); margin-top: 0.5rem;">
                    <i class="fas fa-pen-fancy mr-1"></i> {{ $peminjaman->buku->pengarang ?? '-' }}
                </p>
            </div>
        </div>
    </div>
</div>

@if($peminjaman->pengembalian)
<div class="card mt-4">
    <header class="card-header">
        <p class="card-header-title">
            <i class="fas fa-undo mr-2"></i> Informasi Pengembalian
        </p>
    </header>
    <div class="card-content">
        <div class="columns">
            <div class="column is-3">
                <p class="heading" style="color: rgba(255,255,255,0.5);">ID Pengembalian</p>
                <p style="color: #f5f5f5; font-weight: 600;">{{ $peminjaman->pengembalian->id_pengembalian }}</p>
            </div>
            <div class="column is-3">
                <p class="heading" style="color: rgba(255,255,255,0.5);">Tanggal Kembali</p>
                <p style="color: #f5f5f5;">{{ $peminjaman->pengembalian->tanggal_kembali->format('d F Y') }}</p>
            </div>
            <div class="column is-3">
                <p class="heading" style="color: rgba(255,255,255,0.5);">Denda</p>
                <p style="color: {{ $peminjaman->pengembalian->denda > 0 ? '#f14668' : '#48c78e' }}; font-weight: 600;">
                    Rp {{ number_format($peminjaman->pengembalian->denda, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection