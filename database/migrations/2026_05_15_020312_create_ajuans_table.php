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
        Schema::create('ajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kode_mk')->constrained('mata_kuliahs')->cascadeOnDelete();
            $table->foreignId('kode_kelas')->constrained('kelas')->cascadeOnDelete();
            $table->string('username_dosen');
            $table->foreign('username_dosen')->references('username')->on('users')->cascadeOnDelete();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajuan');
    }
};
