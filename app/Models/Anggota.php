<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_anggota',
        'nama',
        'alamat',
        'no_hp',
    ];

    public function peminjaman()
    {
        return $this->hasMany(TransaksiPeminjaman::class, 'id_anggota', 'id_anggota');
    }
}
