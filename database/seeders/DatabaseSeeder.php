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
            RuanganSeeder::class,
            ProdiSeeder::class,
            MataKuliahSeeder::class,
            KelasSeeder::class
        ]);

        // Ambil ID Prodi akun prodi
        $prodiSI = Prodi::where('nama_prodi', 'S1 Sistem Informasi')->first();
        $prodiSK = Prodi::where('nama_prodi', 'S1 Sistem Komputer')->first();
        $prodiTM = Prodi::where('nama_prodi', 'S1 Teknik Mesin')->first();
        $prodiTE = Prodi::where('nama_prodi', 'S1 Teknik Elektro')->first();
        $prodiMT = Prodi::where('nama_prodi', 'S1 Matematika')->first();
        $prodiBIO = Prodi::where('nama_prodi', 'S1 Biologi')->first();
        $prodiKIM = Prodi::where('nama_prodi', 'S1 Kimia')->first();

        // 2. Buat Akun Admin
        // DatabaseSeeder.php
        User::create([
            'name' => 'Administrator Lab',
            'username' => 'admin', // Login pakai 'admin'
            'password' => Hash::make('password'),
            'prodi_id' => null, 
            'role' => 'admin',
        ]);

        //akun-akun Prodi
        User::create([
            'name' => 'Admin Prodi SI',
            'username' => 'prodi_si', // Login pakai kode prodi
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSI ? $prodiSI->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'prodi',
        ]);
        User::create([
            'name' => 'Admin Prodi Siskom',
            'username' => 'prodi_sk', // Login pakai kode prodi
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSK ? $prodiSK->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'prodi',
        ]);
        User::create([
            'name' => 'Admin Prodi Teknik Mesin',
            'username' => 'prodi_tm', // Login pakai kode prodi
            'password' => Hash::make('password'),
            'prodi_id' => $prodiTM ? $prodiTM->id : null,
            'role' => 'prodi',
        ]);
        User::create([
            'name' => 'Admin Prodi Teknik Elektro',
            'username' => 'prodi_te', // Login pakai kode prodi
            'password' => Hash::make('password'),
            'prodi_id' => $prodiTE ? $prodiTE->id : null,
            'role' => 'prodi',
        ]);
        User::create([
            'name' => 'Admin Prodi Matematika',
            'username' => 'prodi_mt', // Login pakai kode prodi
            'password' => Hash::make('password'),
            'prodi_id' => $prodiMT ? $prodiMT->id : null,
            'role' => 'prodi',
        ]);
        User::create([
            'name' => 'Admin Prodi Biologi',
            'username' => 'prodi_bio', // Login pakai kode prodi
            'password' => Hash::make('password'),
            'prodi_id' => $prodiBIO ? $prodiBIO->id : null,
            'role' => 'prodi',
        ]);
        User::create([
            'name' => 'Admin Prodi Kimia',
            'username' => 'prodi_kim', // Login pakai kode prodi
            'password' => Hash::make('password'),
            'prodi_id' => $prodiKIM ? $prodiKIM->id : null,
            'role' => 'prodi',
        ]);

        //akun-akun dosen
        User::create([
            'name' => 'Leo Sandi',
            'username' => '02900', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSI ? $prodiSI->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Arip Kristiyanto',
            'username' => '10027', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSI ? $prodiSI->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Angga Pramadjaya',
            'username' => '10029', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSI ? $prodiSI->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Joko Yuwono',
            'username' => '02929', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSI ? $prodiSI->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Zayid Musiafa',
            'username' => '03362', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSI ? $prodiSI->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Asep Suryadi',
            'username' => '10008', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSK ? $prodiSK->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'M.Afif Rizky A.',
            'username' => '03235', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSK ? $prodiSK->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Hasan Amin',
            'username' => '03037', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiSK ? $prodiSK->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Joni Arif',
            'username' => '10105', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiTM ? $prodiTM->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Khalil',
            'username' => '03451', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiTE ? $prodiTE->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);
        User::create([
            'name' => 'Euis Aprianti',
            'username' => '02873', // Login pakai NIDOS
            'password' => Hash::make('password'),
            'prodi_id' => $prodiMT ? $prodiMT->id : null, // Set prodi_id jika Prodi SI ditemukan
            'role' => 'dosen',
        ]);

        // $this->call([
        //     AjuanSeeder::class,
        // ]);
    }
}