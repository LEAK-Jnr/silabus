<?php

namespace Database\Seeders;
use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::insert([
            [
                'kode_kelas' => '05SISP001',
                'reguler' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '05SISM001',
                'reguler' => 'B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kelas' => '05SISC005',
                'reguler' => 'C',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
