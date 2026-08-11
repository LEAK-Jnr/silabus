<?php

namespace Database\Seeders;

use App\Models\kelas;
use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasExtension extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Map Kode Prodi (all 12 Prodi)
        $mapProdi = [
            'SIS' => 'S1 Sistem Informasi',
            'SKM' => 'S1 Sistem Komputer',
            'ELS' => 'S1 Teknik Elektro',
            'MSS' => 'S1 Teknik Mesin',
            'MTS' => 'S1 Matematika',
            'KIM' => 'S1 Kimia',
            'BIO' => 'S1 Biologi',
            'AKS' => 'S1 Akuntansi',
            'MJS' => 'S1 Manajemen',
            'HKS' => 'S1 Ilmu Hukum',
            'IPM' => 'S1 Ilmu Pemerintahan',
            'ADN' => 'S1 Administrasi Negara',
        ];

        // Daftar Reguler
        $regulers = [
            'P' => 'Reguler A', 
            'M' => 'Reguler B', 
            'E' => 'Reguler C', 
        ];

        foreach ($mapProdi as $kodeSingkat => $namaProdi) {
            // Ambil ID Prodi dari database berdasarkan nama
            $prodi = Prodi::where('nama_prodi', $namaProdi)->first();

            if ($prodi) {
                // Loop Semester (01 - 08)
                for ($semester = 1; $semester <= 8; $semester++) {
                    $prefixSemester = str_pad($semester, 2, '0', STR_PAD_LEFT);

                    // Loop Tipe Reguler (P, S, K)
                    foreach ($regulers as $kodeReg => $namaReg) {
                        
                        // Loop Urutan Kelas (001 - 012)
                        for ($urutan = 12; $urutan <= 24; $urutan++) {
                            $suffixUrutan = str_pad($urutan, 3, '0', STR_PAD_LEFT);

                            // Gabungkan: 01 + SIS + P + 001
                            $kodeKelasFinal = $prefixSemester . $kodeSingkat . $kodeReg . $suffixUrutan;

                            kelas::create([
                                'kode_kelas' => $kodeKelasFinal,
                                'reguler'    => $namaReg,
                                'prodi_id'   => $prodi->id,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
