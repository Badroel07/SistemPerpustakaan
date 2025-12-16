@extends('layouts.app')

@section('title', 'Pengembalian Baru - Sistem Perpustakaan')
@section('page-title', 'Form Pengembalian')

@section('content')
<div class="card" style="max-width: 700px;">
    <header class="card-header">
        <p class="card-header-title">
            <i class="fas fa-undo mr-2"></i> Input Pengembalian Buku
        </p>
    </header>
    <div class="card-content">
        <form action="{{ route('pengembalian.store') }}" method="POST" id="formPengembalian">
            @csrf

            <div class="field">
                <label class="label">ID Pengembalian</label>
                <div class="control has-icons-left">
                    <input class="input @error('id_pengembalian') is-danger @enderror" type="text" name="id_pengembalian" id="id_pengembalian" placeholder="Loading..." value="{{ old('id_pengembalian') }}" required readonly>
                    <span class="icon is-left"><i class="fas fa-hashtag"></i></span>
                </div>
                @error('id_pengembalian')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Pilih Peminjaman</label>
                <div class="control">
                    <div class="select is-fullwidth @error('id_transaksi_peminjaman') is-danger @enderror">
                        <select name="id_transaksi_peminjaman" id="id_transaksi_peminjaman" required>
                            <option value="">-- Pilih Peminjaman Aktif --</option>
                            @foreach($peminjamanAktif as $p)
                            <option value="{{ $p->id_transaksi }}"
                                data-jatuh-tempo="{{ $p->tanggal_jatuh_tempo->format('Y-m-d') }}"
                                {{ old('id_transaksi_peminjaman') == $p->id_transaksi ? 'selected' : '' }}>
                                {{ $p->id_transaksi }} - {{ $p->anggota->nama ?? '-' }} - {{ $p->buku->judul ?? '-' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('id_transaksi_peminjaman')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
                @if($peminjamanAktif->count() == 0)
                <p class="help is-warning">Tidak ada peminjaman aktif saat ini</p>
                @endif
            </div>

            <div class="field">
                <label class="label">Tanggal Pengembalian</label>
                <div class="control has-icons-left">
                    <input class="input @error('tanggal_kembali') is-danger @enderror" type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali', date('Y-m-d')) }}" required>
                    <span class="icon is-left"><i class="fas fa-calendar"></i></span>
                </div>
                @error('tanggal_kembali')
                <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div id="dendaInfo" class="notification is-light mt-4" style="display: none;">
                <div class="columns is-vcentered">
                    <div class="column">
                        <p class="heading">Status</p>
                        <p id="dendaStatus" class="title is-5">-</p>
                    </div>
                    <div class="column">
                        <p class="heading">Denda</p>
                        <p id="dendaAmount" class="title is-4">Rp 0</p>
                    </div>
                </div>
            </div>

            <div class="field is-grouped mt-5">
                <div class="control">
                    <button type="submit" class="button is-primary" id="btnSubmit">
                        <span class="icon"><i class="fas fa-save"></i></span>
                        <span>Proses Pengembalian</span>
                    </button>
                </div>
                <div class="control">
                    <a href="{{ route('pengembalian.index') }}" class="button is-light">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate return ID
        fetch('{{ route("pengembalian.generate-id") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('id_pengembalian').value = data.id;
            });

        const peminjamanSelect = document.getElementById('id_transaksi_peminjaman');
        const tanggalKembali = document.getElementById('tanggal_kembali');
        const dendaInfo = document.getElementById('dendaInfo');
        const dendaStatus = document.getElementById('dendaStatus');
        const dendaAmount = document.getElementById('dendaAmount');

        function calculateFine() {
            const idPeminjaman = peminjamanSelect.value;
            const tglKembali = tanggalKembali.value;

            if (!idPeminjaman || !tglKembali) {
                dendaInfo.style.display = 'none';
                return;
            }

            fetch('{{ route("pengembalian.hitung-denda") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id_transaksi_peminjaman: idPeminjaman,
                        tanggal_kembali: tglKembali
                    })
                })
                .then(response => response.json())
                .then(data => {
                    dendaInfo.style.display = 'block';
                    if (data.is_late) {
                        dendaInfo.classList.remove('is-success');
                        dendaInfo.classList.add('is-danger');
                        dendaStatus.textContent = 'Terlambat';
                        dendaStatus.style.color = '#f14668';
                    } else {
                        dendaInfo.classList.remove('is-danger');
                        dendaInfo.classList.add('is-success');
                        dendaStatus.textContent = 'Tepat Waktu';
                        dendaStatus.style.color = '#48c78e';
                    }
                    dendaAmount.textContent = data.denda_formatted;
                    dendaAmount.style.color = data.is_late ? '#f14668' : '#48c78e';
                });
        }

        peminjamanSelect.addEventListener('change', calculateFine);
        tanggalKembali.addEventListener('change', calculateFine);

        // Initial calculation if values exist
        if (peminjamanSelect.value) {
            calculateFine();
        }
    });
</script>
@endsection