<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

    // --- PROFILE (Bisa diakses semua role) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. Alamat Route sesuai dengan Role
require __DIR__.'/adminRoutes.php';
require __DIR__.'/dosenRoutes.php';
require __DIR__.'/prodiRoutes.php';