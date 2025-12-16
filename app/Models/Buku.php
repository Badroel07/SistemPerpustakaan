<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_buku',
        'judul',
        'pengarang',
        'kategori',
        'status',
    ];

    public function peminjaman()
    {
        return $this->hasMany(TransaksiPeminjaman::class, 'id_buku', 'id_buku');
    }

    // Check if book is available for borrowing
    public function isAvailable(): bool
    {
        return $this->status === 'tersedia';
    }
}
