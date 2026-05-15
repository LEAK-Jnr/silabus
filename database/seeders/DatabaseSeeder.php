<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Prodi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Jalankan ProdiSeeder dulu (Pastikan sudah buat file ProdiSeeder sebelumnya)
        $this->call([
            ProdiSeeder::class,
            MataKuliahSeeder::class,
            KelasSeeder::class
        ]);

        // Ambil ID Prodi Sistem Informasi untuk akun prodi
        $prodiSI = Prodi::where('nama_prodi', 'S1 Sistem Informasi')->first();

        // 2. Buat Akun Admin
        // DatabaseSeeder.php
        User::create([
            'name' => 'Administrator Lab',
            'username' => 'admin', // Login pakai 'admin'
            'password' => Hash::make('password'),
            'prodi_id' => null, 
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Admin Prodi SI',
            'username' => 'prodi_si', // Login pakai kode prodi
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSI ? $prodiSI->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'prodi',
        ]);

        User::create([
            'name' => 'Leo Sandi',
            'username' => '02900', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSI ? $prodiSI->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Meline Maldini',
            'username' => '03520', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSI ? $prodiSI->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Wowo Gendut',
            'username' => '6666', // Login pakai NIDOS
            'password' => Hash::make('1'),
            'prodi_id' => $prodiSI ? $prodiSI->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'prodi',
        ]);
        $this->call([
            AjuanSeeder::class,
        ]);
    }
}