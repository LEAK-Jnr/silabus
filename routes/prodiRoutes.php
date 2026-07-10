<?php

use App\Http\Controllers\Prodi\ProdiController;
use App\Livewire\Prodi\AjuanProdi;
use App\Livewire\Prodi\JadwalProdi;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // --- KHUSUS ROLE: PRODI ---
    Route::middleware('role:prodi')->group(function () {
        Route::get('/prodi/ajuan', [ProdiController::class, 'index'])->name('prodi.ajuan');
        Route::post('/prodi/ajuan', [ProdiController::class, 'store'])->name('prodi.ajuan.store');
        Route::put('/prodi/ajuan/{id}', [ProdiController::class, 'update'])->name('prodi.ajuan.update');
        Route::delete('/prodi/ajuan/{id}', [ProdiController::class, 'destroy'])->name('prodi.ajuan.destroy');
        
        // using Livewire Class
        Route::get('/prodi/jadwal', JadwalProdi::class)->name('prodi.jadwal');

        // testing
        Route::get('/prodi/test', AjuanProdi::class)->name('prodi.test');
    });    
});