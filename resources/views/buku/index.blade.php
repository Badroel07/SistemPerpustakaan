@extends('layouts.app')

@section('title', 'Data Buku - Sistem Perpustakaan')
@section('page-title', 'Data Buku')

@section('content')
<div class="card">
    <header class="card-header">
        <p class="card-header-title">
            <i class="fas fa-book mr-2"></i> Daftar Buku
        </p>
        <a href="{{ route('buku.create') }}" class="button is-primary is-small m-3">
            <span class="icon"><i class="fas fa-plus"></i></span>
            <span>Tambah Buku</span>
        </a>
    </header>
    <div class="card-content">
        <!-- Search Form -->
        <form action="{{ route('buku.index') }}" method="GET" class="mb-4">
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input class="input" type="text" name="search" placeholder="Cari ID, judul, pengarang, atau kategori..." value="{{ $search ?? '' }}">
                </div>
                <div class="control">
                    <button type="submit" class="button is-info">
                        <span class="icon"><i class="fas fa-search"></i></span>
                        <span>Cari</span>
                    </button>
                </div>
                @if($search ?? false)
                <div class="control">
                    <a href="{{ route('buku.index') }}" class="button is-light">
                        <span class="icon"><i class="fas fa-times"></i></span>
                    </a>
                </div>
                @endif
            </div>
        </form>

        <table class="table is-fullwidth is-striped is-hoverable">
            <thead>
                <tr>
                    <th>ID Buku</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buku as $b)
                <tr>
                    <td>{{ $b->id_buku }}</td>
                    <td>{{ $b->judul }}</td>
                    <td>{{ $b->pengarang ?? '-' }}</td>
                    <td>{{ $b->kategori ?? '-' }}</td>
                    <td>
                        @if($b->status === 'tersedia')
                        <span class="tag is-success">Tersedia</span>
                        @else
                        <span class="tag is-warning">Dipinjam</span>
                        @endif
                    </td>
                    <td>
                        <div class="buttons are-small">
                            <a href="{{ route('buku.show', $b->id_buku) }}" class="button is-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('buku.edit', $b->id_buku) }}" class="button is-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('buku.destroy', $b->id_buku) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button is-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="has-text-centered" style="color: rgba(255,255,255,0.5); padding: 2rem;">
                        Belum ada data buku
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $buku->links('pagination::bulma') }}
        </div>
    </div>
</div>
@endsection