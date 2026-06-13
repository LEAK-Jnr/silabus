<?php

use App\Http\Controllers\Dosen\LaporanKerusakanController;
use App\Http\Controllers\Dosen\PresensiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // --- KHUSUS ROLE: DOSEN ---
    Route::middleware('role:dosen')->group(function () {
        Route::get('/dosen/jadwal', function () {
            return view('dosen.jadwal.index');
        })->name('dosen.jadwal');
        Route::get('/dosen/presensi', [PresensiController::class, 'index'])->name('dosen.presensi');
        Route::get('/dosen/laporan-kerusakan', [LaporanKerusakanController::class, 'index'])->name('dosen.laporan-kerusakan');
    });
});