<?php

namespace Database\Seeders;
use App\Models\Kelas;
use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $si = Prodi::where('nama_prodi', 'S1 Sistem Informasi')->first();
        Kelas::insert([
            [
                'kode_kelas' => '05SISP001',
                'reguler' => 'A',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '05SISM001',
                'reguler' => 'B',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '05SISE005',
                'reguler' => 'C',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '04SISE005',
                'reguler' => 'C',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '04SISP005',
                'reguler' => 'A',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '04SISM005',
                'reguler' => 'B',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '01SISE005',
                'reguler' => 'C',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '01SISP005',
                'reguler' => 'A',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '01SISM005',
                'reguler' => 'B',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '03SISE005',
                'reguler' => 'C',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '03SISP005',
                'reguler' => 'A',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '03SISM005',
                'reguler' => 'B',
                'prodi_id'   => $si->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
