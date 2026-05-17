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
        Schema::create('laporan_kerusakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruangan_id')->constrained('ruangans')->cascadeOnDelete();
            $table->string('username');
            $table->foreign('username')->references('username')->on('users')->cascadeOnDelete();  
            $table->string('nama_barang');
            $table->text('deskripsi_kerusakan');
            $table->enum('tingkat_kerusakan', ['ringan', 'sedang', 'berat'])->default('ringan');
            $table->enum('status_perbaikan', ['belum diperbaiki', 'sedang diperbaiki', 'sudah diperbaiki'])->default('belum diperbaiki');
            $table->text('catatan_perbaikan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakans');
    }
};
