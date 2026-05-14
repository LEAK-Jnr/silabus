<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\MataKuliahController;
use Illuminate\Support\Facades\Route;
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
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        if ($role === 'admin') {
            return view('dashboard');
        } elseif ($role === 'prodi') {
            return view('prodi.ajuan.index');
        } elseif ($role === 'dosen') {
            return view('dosen.jadwal.index');
        }
        abort(403);
    })->name('dashboard');

    // --- KHUSUS ROLE: ADMIN ---
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/prodi', [ProdiController::class, 'index'])->name('admin.prodi.index');
        Route::post('/admin/prodi', [ProdiController::class, 'store'])->name('admin.prodi.store');
        Route::delete('/admin/prodi/{prodi}', [ProdiController::class, 'destroy'])->name('admin.prodi.destroy');
        Route::get('/admin/matakuliah', [MataKuliahController::class, 'index'])->name('admin.matakuliah.index');
        Route::post('/admin/matakuliah', [MataKuliahController::class, 'store'])->name('admin.matakuliah.store');
        Route::delete('/admin/matakuliah/{id}', [MataKuliahController::class, 'destroy'])->name('admin.matakuliah.destroy');
    });

    // --- KHUSUS ROLE: PRODI ---
    Route::middleware('role:prodi')->group(function () {
        Route::get('/prodi/ajuan', function () {
            return view('prodi.ajuan.index');
        })->name('prodi.ajuan');
    });

    // --- KHUSUS ROLE: DOSEN ---
    Route::middleware('role:dosen')->group(function () {
        Route::get('/dosen/jadwal', function () {
            return view('dosen.jadwal.index');
        })->name('dosen.jadwal');
    });

    // --- PROFILE (Bisa diakses semua role) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});