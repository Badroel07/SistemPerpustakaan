<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_pengembalian', function (Blueprint $table) {
            $table->string('id_pengembalian', 20)->primary();
            $table->string('id_transaksi_peminjaman', 20);
            $table->date('tanggal_kembali');
            $table->double('denda')->default(0);
            $table->timestamps();

            $table->foreign('id_transaksi_peminjaman')->references('id_transaksi')->on('transaksi_peminjaman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_pengembalian');
    }
};
