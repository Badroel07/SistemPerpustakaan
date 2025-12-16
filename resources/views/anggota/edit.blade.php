@extends('layouts.app')

@section('title', 'Edit Anggota - Sistem Perpustakaan')
@section('page-title', 'Edit Anggota')

@section('content')
<div class="card" style="max-width: 600px;">
    <header class="card-header">
        <p class="card-header-title">
            <i class="fas fa-user-edit mr-2"></i> Form Edit Anggota
        </p>
    </header>
    <div class="card-content">
        <form action="{{ route('anggota.update', $anggota->id_anggota) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="field">
                <label class="label">ID Anggota</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" value="{{ $anggota->id_anggota }}" disabled>
                    <span class="icon is-left"><i class="fas fa-id-card"></i></span>
                </div>
            </div>

            <div class="field">
                <label class="label">Nama Lengkap</label>
                <div class="control has-icons-left">
                    <input class="input @error('nama') is-danger @enderror" type="text" name="nama" value="{{ old('nama', $anggota->nama) }}" required>
                    <span class="icon is-left"><i class="fas fa-user"></i></span>
                </div>
                @error('nama')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Alamat</label>
                <div class="control">
                    <textarea class="textarea @error('alamat') is-danger @enderror" name="alamat">{{ old('alamat', $anggota->alamat) }}</textarea>
                </div>
                @error('alamat')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">No. HP</label>
                <div class="control has-icons-left">
                    <input class="input @error('no_hp') is-danger @enderror" type="text" name="no_hp" value="{{ old('no_hp', $anggota->no_hp) }}">
                    <span class="icon is-left"><i class="fas fa-phone"></i></span>
                </div>
                @error('no_hp')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field is-grouped mt-5">
                <div class="control">
                    <button type="submit" class="button is-primary">
                        <span class="icon"><i class="fas fa-save"></i></span>
                        <span>Update</span>
                    </button>
                </div>
                <div class="control">
                    <a href="{{ route('anggota.index') }}" class="button is-light">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection