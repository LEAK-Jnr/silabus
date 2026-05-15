<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_ruangan' => 'Laboratorium 01', 'kapasitas' => 40, 'spesifikasi' => 'standar'],
            ['nama_ruangan' => 'Laboratorium 02', 'kapasitas' => 40, 'spesifikasi' => 'standar'],
            ['nama_ruangan' => 'Laboratorium 03 (High-Spec)', 'kapasitas' => 40, 'spesifikasi' => 'tinggi'],
        ];

        foreach ($data as $r) {
            \App\Models\Ruangan::create($r);
        }
    }
}
