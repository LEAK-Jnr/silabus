<?php

use App\Livewire\Prodi\AjuanProdi;
use App\Livewire\Prodi\JadwalProdi;
use App\Livewire\Prodi\PenugasanDosen;
use App\Livewire\Prodi\ProdiIndex;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // --- KHUSUS ROLE: PRODI ---
    Route::middleware('role:prodi')->group(function () {
        // menggunakan prefix untuk awalan prodi/*
        Route::prefix('prodi')->group(function () {
            // Livewire class
            Route::get('/', ProdiIndex::class)->name('prodi');
            Route::get('/penugasan-dosen', PenugasanDosen::class)->name('prodi.penugasan-dosen');
            Route::get('/ajuan', AjuanProdi::class)->name('prodi.ajuan');
            Route::get('/jadwal', JadwalProdi::class)->name('prodi.jadwal');
        });

    });    
});