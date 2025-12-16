<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Peminjaman - {{ $peminjaman->id_transaksi }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <style>
        body {
            font-family: 'Courier New', monospace;
            padding: 20px;
            background: #fff;
        }

        .receipt {
            max-width: 400px;
            margin: 0 auto;
            border: 2px dashed #333;
            padding: 20px;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed #333;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .receipt-header h1 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .receipt-body table {
            width: 100%;
            font-size: 0.9rem;
        }

        .receipt-body td {
            padding: 5px 0;
        }

        .receipt-footer {
            text-align: center;
            border-top: 1px dashed #333;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 0.8rem;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="receipt-header">
            <h1>📚 PERPUSTAKAAN</h1>
            <p>Struk Peminjaman Buku</p>
        </div>

        <div class="receipt-body">
            <table>
                <tr>
                    <td>No. Transaksi</td>
                    <td>: {{ $peminjaman->id_transaksi }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr style="border-style: dashed;">
                    </td>
                </tr>
                <tr>
                    <td>ID Anggota</td>
                    <td>: {{ $peminjaman->anggota->id_anggota ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: {{ $peminjaman->anggota->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr style="border-style: dashed;">
                    </td>
                </tr>
                <tr>
                    <td>ID Buku</td>
                    <td>: {{ $peminjaman->buku->id_buku ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Judul</td>
                    <td>: {{ $peminjaman->buku->judul ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Pengarang</td>
                    <td>: {{ $peminjaman->buku->pengarang ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr style="border-style: dashed;">
                    </td>
                </tr>
                <tr>
                    <td><strong>Jatuh Tempo</strong></td>
                    <td>: <strong>{{ $peminjaman->tanggal_jatuh_tempo->format('d/m/Y') }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="receipt-footer">
            <p>Denda keterlambatan: Rp 1.000/hari</p>
            <p>Terima kasih!</p>
            <br>
            <p>Petugas: {{ $peminjaman->petugas->nama ?? '-' }}</p>
        </div>
    </div>

    <div class="has-text-centered mt-4 no-print">
        <button class="button is-primary" onclick="window.print()">
            🖨️ Cetak Struk
        </button>
        <button class="button" onclick="window.close()">Tutup</button>
    </div>
</body>

</html>