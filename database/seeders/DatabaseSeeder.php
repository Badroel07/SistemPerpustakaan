<?php

namespace Database\Seeders;

use App\Models\Petugas;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 1 Petugas (Librarian)
        Petugas::create([
            'id_petugas' => 'PTG001',
            'nama' => 'Admin Perpustakaan',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Create 2 Anggota (Members)
        Anggota::create([
            'id_anggota' => 'ANG001',
            'nama' => 'Ahmad Fauzi',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'no_hp' => '081234567890',
        ]);

        Anggota::create([
            'id_anggota' => 'ANG002',
            'nama' => 'Siti Rahma',
            'alamat' => 'Jl. Sudirman No. 45, Bandung',
            'no_hp' => '082345678901',
        ]);

        // Create 5 Buku (Books)
        Buku::create([
            'id_buku' => 'BK001',
            'judul' => 'Laskar Pelangi',
            'pengarang' => 'Andrea Hirata',
            'kategori' => 'Novel',
            'status' => 'tersedia',
        ]);

        Buku::create([
            'id_buku' => 'BK002',
            'judul' => 'Bumi Manusia',
            'pengarang' => 'Pramoedya Ananta Toer',
            'kategori' => 'Novel',
            'status' => 'tersedia',
        ]);

        Buku::create([
            'id_buku' => 'BK003',
            'judul' => 'Negeri 5 Menara',
            'pengarang' => 'Ahmad Fuadi',
            'kategori' => 'Novel',
            'status' => 'tersedia',
        ]);

        Buku::create([
            'id_buku' => 'BK004',
            'judul' => 'Pemrograman PHP',
            'pengarang' => 'Abdul Kadir',
            'kategori' => 'Teknologi',
            'status' => 'tersedia',
        ]);

        Buku::create([
            'id_buku' => 'BK005',
            'judul' => 'Sejarah Indonesia Modern',
            'pengarang' => 'M.C. Ricklefs',
            'kategori' => 'Sejarah',
            'status' => 'tersedia',
        ]);
    }
}
