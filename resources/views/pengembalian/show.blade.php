@extends('layouts.app')

@section('title', 'Detail Pengembalian - Sistem Perpustakaan')
@section('page-title', 'Detail Pengembalian')

@section('content')
<div class="columns">
    <div class="column is-8">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <i class="fas fa-info-circle mr-2"></i> Informasi Pengembalian
                </p>
            </header>
            <div class="card-content">
                <div class="columns">
                    <div class="column is-6">
                        <table class="table is-fullwidth" style="background: transparent;">
                            <tr>
                                <td style="color: rgba(255,255,255,0.5);">ID Pengembalian</td>
                                <td style="color: #f5f5f5; font-weight: 600;">{{ $pengembalian->id_pengembalian }}</td>
                            </tr>
                            <tr>
                                <td style="color: rgba(255,255,255,0.5);">ID Peminjaman</td>
                                <td style="color: #f5f5f5;">{{ $pengembalian->peminjaman->id_transaksi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="color: rgba(255,255,255,0.5);">Tgl Pinjam</td>
                                <td style="color: #f5f5f5;">{{ $pengembalian->peminjaman->tanggal_pinjam->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td style="color: rgba(255,255,255,0.5);">Jatuh Tempo</td>
                                <td style="color: #f5f5f5;">{{ $pengembalian->peminjaman->tanggal_jatuh_tempo->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td style="color: rgba(255,255,255,0.5);">Tgl Kembali</td>
                                <td style="color: #f5f5f5; font-weight: 600;">{{ $pengembalian->tanggal_kembali->format('d F Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="column is-6">
                        <table class="table is-fullwidth" style="background: transparent;">
                            <tr>
                                <td style="color: rgba(255,255,255,0.5);">Anggota</td>
                                <td style="color: #f5f5f5;">{{ $pengembalian->peminjaman->anggota->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="color: rgba(255,255,255,0.5);">Buku</td>
                                <td style="color: #f5f5f5;">{{ $pengembalian->peminjaman->buku->judul ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="color: rgba(255,255,255,0.5);">Petugas</td>
                                <td style="color: #f5f5f5;">{{ $pengembalian->peminjaman->petugas->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="color: rgba(255,255,255,0.5);">Denda</td>
                                <td>
                                    <span class="tag is-{{ $pengembalian->denda > 0 ? 'danger' : 'success' }} is-medium">
                                        Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="buttons mt-5">
                    <a href="{{ route('pengembalian.cetak', $pengembalian->id_pengembalian) }}" class="button is-info" target="_blank">
                        <span class="icon"><i class="fas fa-print"></i></span>
                        <span>Cetak Struk</span>
                    </a>
                    <a href="{{ route('pengembalian.index') }}" class="button is-light">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection