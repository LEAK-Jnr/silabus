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

        $data = [
            [
                'prodi_id' => $prodiTE->id,
                'kode_mk' => 'TE101',
                'nama_mk' => 'Pemrograman Dasar',
                'sks' => 3,
                'skor_prioritas' => 70,
                'spesifikasi' => 'standar',
            ],
            [
                'prodi_id' => $prodiTE->id,
                'kode_mk' => 'TE305',
                'nama_mk' => 'Menggambar Teknik',
                'sks' => 3,
                'skor_prioritas' => 85,
                'spesifikasi' => 'tinggi', // Akan masuk Lab 3
            ],
            [
                'prodi_id' => $prodiSI->id,
                'kode_mk' => 'SIF202',
                'nama_mk' => 'Algoritma Pemrograman',
                'sks' => 2,
                'skor_prioritas' => 80,
                'spesifikasi' => 'standar',
            ],
            [
                'prodi_id' => $prodiSI->id,
                'kode_mk' => 'SIF401',
                'nama_mk' => 'Mobile Programming',
                'sks' => 3,
                'skor_prioritas' => 75,
                'spesifikasi' => 'tinggi', // Akan masuk Lab 3
            ],
            [
                'prodi_id' => $prodiSI->id,
                'kode_mk' => 'SIF405',
                'nama_mk' => 'Pemograman Web I',
                'sks' => 3,
                'skor_prioritas' => 75,
                'spesifikasi' => 'tinggi', 
            ],
        ];

        foreach ($data as $item) {
            MataKuliah::create($item);
        }
    }
}