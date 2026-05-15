<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ajuan;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Arr;

class AjuanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua kelas yang tersedia
        $banyakKelas = Kelas::pluck('id')->toArray();
        
        // Ambil semua data user dosen lengkap dengan prodi_id mereka
        $banyakDosen = User::where('role', 'dosen')->get();

        if ($banyakDosen->isEmpty() || empty($banyakKelas)) {
            return;
        }

        $statuses = ['menunggu', 'disetujui', 'ditolak'];
        $usedMkIds = []; // Variabel pelacak mata kuliah yang sudah diajukan

        foreach ($banyakDosen as $index => $dosen) {
            // Ambil mata kuliah yang khusus sesuai prodi si dosen
            $banyakMk = MataKuliah::where('prodi_id', $dosen->prodi_id)->pluck('id')->toArray();

            // Antisipasi jika prodi dosen belum punya mata kuliah, ambil dari semua MK yang ada
            if (empty($banyakMk)) {
                $banyakMk = MataKuliah::pluck('id')->toArray();
            }

            // Saring MK yang belum pernah dipilih di iterasi sebelumnya
            $availableMk = array_diff($banyakMk, $usedMkIds);

            // Jika semua MK di prodi ini sudah dipakai, coba ambil dari sisa semua MK di database
            if (empty($availableMk)) {
                $semuaMk = MataKuliah::pluck('id')->toArray();
                $availableMk = array_diff($semuaMk, $usedMkIds);
            }

            // Jika benar-benar semua MK sudah diajukan, lewati
            if (empty($availableMk)) {
                continue;
            }

            // Pilih satu MK secara acak dari yang masih tersedia
            $terpilihMk = Arr::random($availableMk);
            
            // Catat MK yang tepilih agar tidak dipakai lagi
            $usedMkIds[] = $terpilihMk;

            $statusTerpilih = $statuses[$index % count($statuses)];

            Ajuan::create([
                'kode_mk'        => $terpilihMk, 
                'kode_kelas'     => Arr::random($banyakKelas), 
                'username_dosen' => $dosen->username,
                'status'         => $statusTerpilih,
            ]);
        }
    }
}
