@extends('layouts.app')

@section('title', 'Peminjaman Baru - Sistem Perpustakaan')
@section('page-title', 'Form Peminjaman')

@section('content')
<div class="card" style="max-width: 700px;">
    <header class="card-header">
        <p class="card-header-title">
            <i class="fas fa-hand-holding mr-2"></i> Input Peminjaman Buku
        </p>
    </header>
    <div class="card-content">
        <form action="{{ route('peminjaman.store') }}" method="POST" id="formPeminjaman">
            @csrf

            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        <label class="label">ID Transaksi</label>
                        <div class="control has-icons-left">
                            <input class="input @error('id_transaksi') is-danger @enderror" type="text" name="id_transaksi" id="id_transaksi" placeholder="Loading..." value="{{ old('id_transaksi') }}" required readonly>
                            <span class="icon is-left"><i class="fas fa-hashtag"></i></span>
                        </div>
                        @error('id_transaksi')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Petugas</label>
                        <div class="control has-icons-left">
                            <input class="input" type="text" value="{{ Auth::guard('petugas')->user()->nama }}" disabled>
                            <span class="icon is-left"><i class="fas fa-user-tie"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Anggota</label>
                <div class="control">
                    <div class="select is-fullwidth @error('id_anggota') is-danger @enderror">
                        <select name="id_anggota" required>
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggota as $a)
                            <option value="{{ $a->id_anggota }}" {{ old('id_anggota') == $a->id_anggota ? 'selected' : '' }}>
                                {{ $a->id_anggota }} - {{ $a->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('id_anggota')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Buku</label>
                <div class="control">
                    <div class="select is-fullwidth @error('id_buku') is-danger @enderror">
                        <select name="id_buku" required>
                            <option value="">-- Pilih Buku (Tersedia) --</option>
                            @foreach($buku as $b)
                            <option value="{{ $b->id_buku }}" {{ old('id_buku') == $b->id_buku ? 'selected' : '' }}>
                                {{ $b->id_buku }} - {{ $b->judul }} ({{ $b->pengarang ?? 'Unknown' }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('id_buku')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
                @if($buku->count() == 0)
                <p class="help is-warning">Tidak ada buku yang tersedia saat ini</p>
                @endif
            </div>

            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Tanggal Pinjam</label>
                        <div class="control has-icons-left">
                            <input class="input @error('tanggal_pinjam') is-danger @enderror" type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                            <span class="icon is-left"><i class="fas fa-calendar"></i></span>
                        </div>
                        @error('tanggal_pinjam')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Tanggal Jatuh Tempo</label>
                        <div class="control has-icons-left">
                            <input class="input @error('tanggal_jatuh_tempo') is-danger @enderror" type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo', date('Y-m-d', strtotime('+7 days'))) }}" required>
                            <span class="icon is-left"><i class="fas fa-calendar-check"></i></span>
                        </div>
                        @error('tanggal_jatuh_tempo')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="notification is-info is-light mt-4">
                <i class="fas fa-info-circle mr-2"></i>
                Durasi peminjaman default adalah 7 hari. Denda keterlambatan: Rp 1.000/hari.
            </div>

            <div class="field is-grouped mt-5">
                <div class="control">
                    <button type="submit" class="button is-primary">
                        <span class="icon"><i class="fas fa-save"></i></span>
                        <span>Simpan Peminjaman</span>
                    </button>
                </div>
                <div class="control">
                    <a href="{{ route('peminjaman.index') }}" class="button is-light">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate transaction ID
        fetch('{{ route("peminjaman.generate-id") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('id_transaksi').value = data.id;
            });

        // Auto-calculate due date when borrow date changes
        document.getElementById('tanggal_pinjam').addEventListener('change', function() {
            const borrowDate = new Date(this.value);
            borrowDate.setDate(borrowDate.getDate() + 7);
            const dueDate = borrowDate.toISOString().split('T')[0];
            document.getElementById('tanggal_jatuh_tempo').value = dueDate;
        });
    });
</script>
@endsection