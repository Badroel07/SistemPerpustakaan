@extends('layouts.app')

@section('title', 'Edit Buku - Sistem Perpustakaan')
@section('page-title', 'Edit Buku')

@section('content')
<div class="card" style="max-width: 600px;">
    <header class="card-header">
        <p class="card-header-title">
            <i class="fas fa-book mr-2"></i> Form Edit Buku
        </p>
    </header>
    <div class="card-content">
        <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="field">
                <label class="label">ID Buku</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" value="{{ $buku->id_buku }}" disabled>
                    <span class="icon is-left"><i class="fas fa-barcode"></i></span>
                </div>
            </div>

            <div class="field">
                <label class="label">Judul Buku</label>
                <div class="control has-icons-left">
                    <input class="input @error('judul') is-danger @enderror" type="text" name="judul" value="{{ old('judul', $buku->judul) }}" required>
                    <span class="icon is-left"><i class="fas fa-heading"></i></span>
                </div>
                @error('judul')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Pengarang</label>
                <div class="control has-icons-left">
                    <input class="input @error('pengarang') is-danger @enderror" type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}">
                    <span class="icon is-left"><i class="fas fa-pen-fancy"></i></span>
                </div>
                @error('pengarang')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Kategori</label>
                <div class="control has-icons-left">
                    <input class="input @error('kategori') is-danger @enderror" type="text" name="kategori" value="{{ old('kategori', $buku->kategori) }}">
                    <span class="icon is-left"><i class="fas fa-tags"></i></span>
                </div>
                @error('kategori')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Status</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="status" required>
                            <option value="tersedia" {{ old('status', $buku->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipinjam" {{ old('status', $buku->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="field is-grouped mt-5">
                <div class="control">
                    <button type="submit" class="button is-primary">
                        <span class="icon"><i class="fas fa-save"></i></span>
                        <span>Update</span>
                    </button>
                </div>
                <div class="control">
                    <a href="{{ route('buku.index') }}" class="button is-light">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection