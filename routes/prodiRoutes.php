<?php

use App\Livewire\Prodi\Ajuan\AjuanProdiIndex;
use App\Livewire\Prodi\Jadwal\ProdiJadwalIndex;
use App\Livewire\Prodi\PenugasanDosen\PenugasanDosenIndex;
use App\Livewire\Prodi\ProdiIndex;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // --- KHUSUS ROLE: PRODI ---
    Route::middleware('role:prodi')->group(function () {
        // menggunakan prefix untuk awalan prodi/*
        Route::prefix('prodi')->group(function () {
            // Livewire class
            Route::get('/', ProdiIndex::class)->name('prodi');
            Route::get('/penugasan-dosen', PenugasanDosenIndex::class)->name('prodi.penugasan-dosen');
            Route::get('/ajuan', AjuanProdiIndex::class)->name('prodi.ajuan');
            Route::get('/jadwal', ProdiJadwalIndex::class)->name('prodi.jadwal');
        });

    });    
});