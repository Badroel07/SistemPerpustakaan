<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPengembalian extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pengembalian';
    protected $primaryKey = 'id_pengembalian';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pengembalian',
        'id_transaksi_peminjaman',
        'tanggal_kembali',
        'denda',
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
        'denda' => 'double',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(TransaksiPeminjaman::class, 'id_transaksi_peminjaman', 'id_transaksi');
    }

    // Calculate fine based on late days (Rp 1000 per day)
    public static function calculateFine($tanggalJatuhTempo, $tanggalKembali): float
    {
        $dueDate = \Carbon\Carbon::parse($tanggalJatuhTempo);
        $returnDate = \Carbon\Carbon::parse($tanggalKembali);

        if ($returnDate->greaterThan($dueDate)) {
            $lateDays = $dueDate->diffInDays($returnDate);
            return $lateDays * 1000; // Rp 1000 per day
        }

        return 0;
    }
}
