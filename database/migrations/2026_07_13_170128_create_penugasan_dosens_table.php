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
        Schema::create('penugasan_dosens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodi_id')->constrained('prodis')->onDelete('cascade');
            $table->string('kd_dosen');
            $table->foreign('kd_dosen')->references('username')->on('users')->onDelete('cascade');
            $table->foreignId('matakuliah_id')->constrained('mata_kuliahs')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->timestamps();

            // Mencegah Matakuliah A di Kelas B diampu oleh Dosen X DAN Dosen Y secara bersamaan
            // 1 Kelas + 1 Matakuliah HANYA Boleh Diampu oleh 1 Dosen
            $table->unique(['matakuliah_id', 'kelas_id'], 'unique_mk_kelas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasan_dosens');
    }
};
