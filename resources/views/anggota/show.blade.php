@extends('layouts.app')

@section('title', 'Detail Anggota - Sistem Perpustakaan')
@section('page-title', 'Detail Anggota')

@section('content')
<div class="columns">
    <div class="column is-4">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <i class="fas fa-user mr-2"></i> Informasi Anggota
                </p>
            </header>
            <div class="card-content">
                <div class="mb-4">
                    <p class="heading" style="color: rgba(255,255,255,0.5);">ID Anggota</p>
                    <p class="title is-5" style="color: #f5f5f5;">{{ $anggota->id_anggota }}</p>
                </div>
                <div class="mb-4">
                    <p class="heading" style="color: rgba(255,255,255,0.5);">Nama</p>
                    <p class="title is-5" style="color: #f5f5f5;">{{ $anggota->nama }}</p>
                </div>
                <div class="mb-4">
                    <p class="heading" style="color: rgba(255,255,255,0.5);">Alamat</p>
                    <p style="color: rgba(255,255,255,0.8);">{{ $anggota->alamat ?? '-' }}</p>
                </div>
                <div class="mb-4">
                    <p class="heading" style="color: rgba(255,255,255,0.5);">No. HP</p>
                    <p style="color: rgba(255,255,255,0.8);">{{ $anggota->no_hp ?? '-' }}</p>
                </div>
                <div class="mb-4">
                    <p class="heading" style="color: rgba(255,255,255,0.5);">Terdaftar</p>
                    <p style="color: rgba(255,255,255,0.8);">{{ $anggota->created_at->format('d M Y, H:i') }}</p>
                </div>

                <div class="buttons mt-5">
                    <a href="{{ route('anggota.edit', $anggota->id_anggota) }}" class="button is-warning">
                        <span class="icon"><i class="fas fa-edit"></i></span>
                        <span>Edit</span>
                    </a>
                    <a href="{{ route('anggota.index') }}" class="button is-light">Kembali</a>
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
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman as $p)
                        <tr>
                            <td>{{ $p->id_transaksi }}</td>
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