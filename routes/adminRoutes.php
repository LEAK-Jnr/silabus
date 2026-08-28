<?php

use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\RuanganController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (){
    // --- KHUSUS ROLE: ADMIN ---
    Route::middleware('role:admin')->group(function () {
        // Menu Prodi
        Route::get('/admin/prodi', [ProdiController::class, 'index'])->name('admin.prodi.index');
        Route::post('/admin/prodi', [ProdiController::class, 'store'])->name('admin.prodi.store');
        Route::put('/admin/prodi/{prodi}', [ProdiController::class, 'update'])->name('admin.prodi.update');
        Route::delete('/admin/prodi/{prodi}', [ProdiController::class, 'destroy'])->name('admin.prodi.destroy');
        
        // Menu Dosen
        Route::get('/admin/dosen', [App\Http\Controllers\Admin\DosenController::class, 'index'])->name('admin.dosen.index');
        Route::post('/admin/dosen', [App\Http\Controllers\Admin\DosenController::class, 'store'])->name('admin.dosen.store');
        Route::put('/admin/dosen/{dosen}', [App\Http\Controllers\Admin\DosenController::class, 'update'])->name('admin.dosen.update');
        Route::delete('/admin/dosen/{dosen}', [App\Http\Controllers\Admin\DosenController::class, 'destroy'])->name('admin.dosen.destroy');
        
        // Menu Mata Kuliah
        Route::get('/admin/matakuliah', [MataKuliahController::class, 'index'])->name('admin.matakuliah.index');
        Route::post('/admin/matakuliah', [MataKuliahController::class, 'store'])->name('admin.matakuliah.store');
        Route::put('/admin/matakuliah/{id}', [MataKuliahController::class, 'update'])->name('admin.matakuliah.update');
        Route::delete('/admin/matakuliah/{id}', [MataKuliahController::class, 'destroy'])->name('admin.matakuliah.destroy');
        
        // Menu Ruangan
        Route::get('/admin/ruangan', [RuanganController::class, 'index'])->name('admin.ruangan.index');
        Route::post('/admin/ruangan', [RuanganController::class, 'store'])->name('admin.ruangan.store');
        Route::put('/admin/ruangan/{ruangan}', [RuanganController::class, 'update'])->name('admin.ruangan.update');
        Route::delete('/admin/ruangan/{ruangan}', [RuanganController::class, 'destroy'])->name('admin.ruangan.destroy');

        // --- MENU JADWAL (PLOTTING OTOMATIS) ---
        Route::get('/admin/jadwal/export-pdf-all', [JadwalController::class, 'exportPdfAll'])->name('admin.jadwal.export-pdf-all');
        Route::get('/admin/jadwal/export-pdf', [JadwalController::class, 'exportPdf'])->name('admin.jadwal.export-pdf');
        Route::get('/admin/jadwal', [JadwalController::class, 'index'])->name('admin.jadwal.index');
        Route::post('/admin/jadwal/generate', [JadwalController::class, 'generate'])->name('admin.jadwal.generate');
        Route::put('/admin/jadwal/{ajuan}/update-plot', [JadwalController::class, 'updatePlot'])->name('admin.jadwal.update-plot');
        Route::post('/admin/jadwal/{ajuan}/checkin', [JadwalController::class, 'checkIn'])->name('admin.jadwal.checkin');
        Route::post('/admin/jadwal/{ajuan}/checkout', [JadwalController::class, 'checkOut'])->name('admin.jadwal.checkout');
        Route::put('/admin/jadwal/rollback', [JadwalController::class, 'rollback'])->name('rollback-ajuan');
    });
});