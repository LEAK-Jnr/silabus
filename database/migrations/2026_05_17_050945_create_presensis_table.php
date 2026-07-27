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
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->string('user_username');
            $table->foreign('user_username')->references('username')->on('users')->cascadeOnDelete();
            $table->foreignId('ajuan_id')->constrained('ajuans')->cascadeOnDelete(); 
            $table->date('tanggal'); 
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status', ['hadir', 'terlambat', 'tidak_hadir'])->default('hadir');    
            $table->integer('keterlambatan_menit')->nullable()->default(0);  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
