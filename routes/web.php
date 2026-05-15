<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\RuanganController;
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
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/prodi', [ProdiController::class, 'index'])->name('prodi.index');
        Route::post('/prodi', [ProdiController::class, 'store'])->name('prodi.store');
        Route::delete('/prodi/{prodi}', [ProdiController::class, 'destroy'])->name('prodi.destroy');

        Route::get('/matakuliah', [MataKuliahController::class, 'index'])->name('matakuliah.index');
        Route::post('/matakuliah', [MataKuliahController::class, 'store'])->name('matakuliah.store');
        Route::delete('/matakuliah/{id}', [MataKuliahController::class, 'destroy'])->name('matakuliah.destroy');

        Route::resource('ruangan', RuanganController::class);
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