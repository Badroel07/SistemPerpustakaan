<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Pengembalian - {{ $pengembalian->id_pengembalian }}</title>
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

        .fine-box {
            background: {
                    {
                    $pengembalian->denda >0 ? '#ffdddd': '#ddffdd'
                }
            }

            ;
            padding: 10px;
            text-align: center;
            margin: 10px 0;
            border-radius: 5px;
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
            <p>Struk Pengembalian Buku</p>
        </div>

        <div class="receipt-body">
            <table>
                <tr>
                    <td>No. Pengembalian</td>
                    <td>: {{ $pengembalian->id_pengembalian }}</td>
                </tr>
                <tr>
                    <td>No. Peminjaman</td>
                    <td>: {{ $pengembalian->peminjaman->id_transaksi ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Tanggal Kembali</td>
                    <td>: {{ $pengembalian->tanggal_kembali->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr style="border-style: dashed;">
                    </td>
                </tr>
                <tr>
                    <td>ID Anggota</td>
                    <td>: {{ $pengembalian->peminjaman->anggota->id_anggota ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: {{ $pengembalian->peminjaman->anggota->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr style="border-style: dashed;">
                    </td>
                </tr>
                <tr>
                    <td>ID Buku</td>
                    <td>: {{ $pengembalian->peminjaman->buku->id_buku ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Judul</td>
                    <td>: {{ $pengembalian->peminjaman->buku->judul ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr style="border-style: dashed;">
                    </td>
                </tr>
                <tr>
                    <td>Tgl Pinjam</td>
                    <td>: {{ $pengembalian->peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>Jatuh Tempo</td>
                    <td>: {{ $pengembalian->peminjaman->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                </tr>
            </table>

            <div class="fine-box">
                <strong>DENDA: Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</strong>
            </div>
        </div>

        <div class="receipt-footer">
            <p>Terima kasih telah mengembalikan buku!</p>
            <br>
            <p>Petugas: {{ $pengembalian->peminjaman->petugas->nama ?? '-' }}</p>
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