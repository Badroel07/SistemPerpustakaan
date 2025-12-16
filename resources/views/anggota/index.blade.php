@extends('layouts.app')

@section('title', 'Data Anggota - Sistem Perpustakaan')
@section('page-title', 'Data Anggota')

@section('content')
<div class="card">
    <header class="card-header">
        <p class="card-header-title">
            <i class="fas fa-users mr-2"></i> Daftar Anggota
        </p>
        <a href="{{ route('anggota.create') }}" class="button is-primary is-small m-3">
            <span class="icon"><i class="fas fa-plus"></i></span>
            <span>Tambah Anggota</span>
        </a>
    </header>
    <div class="card-content">
        <!-- Search Form -->
        <form action="{{ route('anggota.index') }}" method="GET" class="mb-4">
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input class="input" type="text" name="search" placeholder="Cari ID, nama, alamat, atau no. HP..." value="{{ $search ?? '' }}">
                </div>
                <div class="control">
                    <button type="submit" class="button is-info">
                        <span class="icon"><i class="fas fa-search"></i></span>
                        <span>Cari</span>
                    </button>
                </div>
                @if($search ?? false)
                <div class="control">
                    <a href="{{ route('anggota.index') }}" class="button is-light">
                        <span class="icon"><i class="fas fa-times"></i></span>
                    </a>
                </div>
                @endif
            </div>
        </form>

        <table class="table is-fullwidth is-striped is-hoverable">
            <thead>
                <tr>
                    <th>ID Anggota</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggota as $a)
                <tr>
                    <td>{{ $a->id_anggota }}</td>
                    <td>{{ $a->nama }}</td>
                    <td>{{ $a->alamat ?? '-' }}</td>
                    <td>{{ $a->no_hp ?? '-' }}</td>
                    <td>
                        <div class="buttons are-small">
                            <a href="{{ route('anggota.show', $a->id_anggota) }}" class="button is-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('anggota.edit', $a->id_anggota) }}" class="button is-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('anggota.destroy', $a->id_anggota) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
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
                    <td colspan="5" class="has-text-centered" style="color: rgba(255,255,255,0.5); padding: 2rem;">
                        Belum ada data anggota
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $anggota->links('pagination::bulma') }}
        </div>
    </div>
</div>
@endsection