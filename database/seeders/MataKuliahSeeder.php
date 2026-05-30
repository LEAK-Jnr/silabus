<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataKuliah;
use App\Models\Prodi;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID Prodi yang sudah ada (pastikan sudah jalankan ProdiSeeder sebelumnya)
        $prodiTE = Prodi::where('nama_prodi', 'S1 Teknik Elektro')->first();
        $prodiSI = Prodi::where('nama_prodi', 'S1 Sistem Informasi')->first();
        $prodiTM = Prodi::where('nama_prodi', 'S1 Teknik Mesin')->first();
        $prodiMT = Prodi::where('nama_prodi', 'S1 Matematika')->first();

        $data = [
            [
                'prodi_id' => $prodiTE->id,
                'kode_mk' => 'TEK0012',
                'nama_mk' => 'Dasar Komputer Dan Pemrograman',
                'sks' => 2,
                'skor_prioritas' => 45,
                'spesifikasi' => 'standar',
            ],
            [
                'prodi_id' => $prodiTM->id,
                'kode_mk' => 'TMS0023',
                'nama_mk' => 'Menggambar Teknik Berbasis Komputer',
                'sks' => 3,
                'skor_prioritas' => 80,
                'spesifikasi' => 'tinggi', // Akan masuk Lab 3
            ],
            [
                'prodi_id' => $prodiSI->id,
                'kode_mk' => 'SIF0013',
                'nama_mk' => 'Algoritma Pemrograman',
                'sks' => 3,
                'skor_prioritas' => 80,
                'spesifikasi' => 'standar',
            ],
            [
                'prodi_id' => $prodiSI->id,
                'kode_mk' => 'SIF0233',
                'nama_mk' => 'Mobile Programming',
                'sks' => 3,
                'skor_prioritas' => 65,
                'spesifikasi' => 'tinggi', // Akan masuk Lab 3
            ],
            [
                'prodi_id' => $prodiSI->id,
                'kode_mk' => 'SIF0293',
                'nama_mk' => 'Pemograman Web I',
                'sks' => 3,
                'skor_prioritas' => 65,
                'spesifikasi' => 'standar', 
            ],
            [
                'prodi_id' => $prodiMT->id,
                'kode_mk' => 'SIF405',
                'nama_mk' => 'Data Mining',
                'sks' => 2,
                'skor_prioritas' => 45,
                'spesifikasi' => 'standar', 
            ],
        ];

        foreach ($data as $item) {
            MataKuliah::create($item);
        }
    }
}