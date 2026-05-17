<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProdiController as AdminProdiController;
use App\Http\Controllers\Prodi\ProdiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\JadwalController; 
use App\Http\Controllers\Dosen\PresensiController;
use App\Http\Controllers\Dosen\LaporanKerusakanController;
use Illuminate\Support\Facades\Auth;

// 1. Landing Page Pintar
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// 2. Rute Autentikasi (Breeze)
require __DIR__.'/auth.php';

// 3. Grup Middleware Utama (Harus Login)
Route::middleware(['auth'])->group(function () {

    // DASHBOARD PINTAR: Satu rute untuk semua, tapi tampilan beda-beda
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');


    // --- KHUSUS ROLE: ADMIN ---
    Route::middleware('role:admin')->group(function () {
        // Menu Prodi
        Route::get('/admin/prodi', [AdminProdiController::class, 'index'])->name('admin.prodi.index');
        Route::post('/admin/prodi', [AdminProdiController::class, 'store'])->name('admin.prodi.store');
        Route::put('/admin/prodi/{prodi}', [AdminProdiController::class, 'update'])->name('admin.prodi.update');
        Route::delete('/admin/prodi/{prodi}', [AdminProdiController::class, 'destroy'])->name('admin.prodi.destroy');
        
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
        Route::get('/admin/jadwal', [JadwalController::class, 'index'])->name('admin.jadwal.index');
        Route::post('/admin/jadwal/generate', [JadwalController::class, 'generate'])->name('admin.jadwal.generate');
    });

    // --- KHUSUS ROLE: PRODI ---
    Route::middleware('role:prodi')->group(function () {
        Route::get('/prodi/ajuan', [ProdiController::class, 'index'])->name('prodi.ajuan');
        Route::post('/prodi/ajuan', [ProdiController::class, 'store'])->name('prodi.ajuan.store');
        Route::put('/prodi/ajuan/{id}', [ProdiController::class, 'update'])->name('prodi.ajuan.update');
        Route::delete('/prodi/ajuan/{id}', [ProdiController::class, 'destroy'])->name('prodi.ajuan.destroy');
    });

    // --- KHUSUS ROLE: DOSEN ---
    Route::middleware('role:dosen')->group(function () {
        Route::get('/dosen/jadwal', function () {
            return view('dosen.jadwal.index');
        })->name('dosen.jadwal');
        Route::get('/dosen/presensi', [PresensiController::class, 'index'])->name('dosen.presensi');
        Route::get('/dosen/laporan-kerusakan', [LaporanKerusakanController::class, 'index'])->name('dosen.laporan-kerusakan');
    });

    // --- PROFILE (Bisa diakses semua role) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});