<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prodi;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //seeder prodi
        $prodi = [
            ['nama_prodi' => 'S1 Sistem Informasi', 'bobot_prioritas' => 5],
            ['nama_prodi' => 'S1 Sistem Komputer', 'bobot_prioritas' => 5],
            ['nama_prodi' => 'S1 Teknik Elektro', 'bobot_prioritas' => 5],
            ['nama_prodi' => 'S1 Teknik Mesin', 'bobot_prioritas' => 5],
            ['nama_prodi' => 'S1 Matematika', 'bobot_prioritas' => 5],
            ['nama_prodi' => 'S1 Kimia', 'bobot_prioritas' => 3],
            ['nama_prodi' => 'S1 Biologi', 'bobot_prioritas' => 3],
            ['nama_prodi' => 'S1 Akuntansi', 'bobot_prioritas' => 1],
            ['nama_prodi' => 'S1 Manajemen', 'bobot_prioritas' => 1],
            ['nama_prodi' => 'S1 Administrasi Negara', 'bobot_prioritas' => 1],
            ['nama_prodi' => 'S1 Ilmu Pemerintahan', 'bobot_prioritas' => 1],
            ['nama_prodi' => 'S1 Ilmu Hukum', 'bobot_prioritas' => 1],
        ];

        foreach ($prodi as $p) {
            Prodi::create($p);
        }
    }
}
