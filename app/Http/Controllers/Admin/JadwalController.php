<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Ajuan;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal dengan filter pekan
     */
    public function index(Request $request)
    {
        $pekanAktif = $request->get('pekan', 1);

        $ajuans = Ajuan::with(['mataKuliah', 'kelas', 'dosen', 'ruangan'])
            ->where('pekan', $pekanAktif)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('admin.jadwal.index', compact('ajuans', 'pekanAktif'));
    }

    /**
     * Algoritma Plotting Otomatis berdasarkan Prioritas
     */
    public function generate()
    {
        $slotWaktu = [
            'A' => [
                'hari' => ['Senin', 'Selasa', 'Rabu', 'Jumat'],
                'jam'  => [['07:10:00', '08:50:00'], ['08:50:00', '10:30:00'], ['10:30:00', '12:10:00'], ['13:00:00', '14:40:00'], ['14:40:00', '16:20:00']]
            ],
            'B' => [
                'hari' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                'jam'  => [['18:20:00', '20:00:00'], ['20:00:00', '21:40:00']]
            ],
            'C' => [
                'hari' => ['Sabtu'],
                'jam'  => [['07:40:00', '09:20:00'], ['09:20:00', '11:00:00'], ['11:00:00', '12:40:00'], ['13:50:00', '15:30:00'], ['16:00:00', '17:40:00']]
            ]
        ];

        $ajuans = Ajuan::where('status', 'menunggu')
            ->join('mata_kuliahs', 'ajuans.kode_mk', '=', 'mata_kuliahs.id')
            ->join('prodis', 'mata_kuliahs.prodi_id', '=', 'prodis.id')
            ->select('ajuans.*')
            ->selectRaw('(prodis.bobot_prioritas * 5 + mata_kuliahs.skor_prioritas) as total_skor')
            ->orderBy('total_skor', 'desc')
            ->get();

        $countSetuju = 0;
        $countTolak = 0;

        foreach ($ajuans as $ajuan) {
            $reguler = strtoupper($ajuan->kelas->reguler); 
            $foundSlot = false;

            if (!isset($slotWaktu[$reguler])) {
                continue;
            }

            foreach ($slotWaktu[$reguler]['hari'] as $hari) {
                foreach ($slotWaktu[$reguler]['jam'] as $jam) {
                    [$start, $end] = $jam;

                    // Cek ketersediaan/bentrok pada slot waktu
                    $isOccupied = Ajuan::where('pekan', $ajuan->pekan)
                        ->where('hari', $hari)
                        ->where('jam_mulai', $start)
                        ->where('status', 'disetujui')
                        ->where(function($q) use ($ajuan) {
                            $q->where('ruangan_id', $ajuan->ruangan_id)
                              ->orWhere('username_dosen', $ajuan->username_dosen)
                              ->orWhere('kode_kelas', $ajuan->kode_kelas);
                        })->exists();

                    if (!$isOccupied) {
                        // REFAKTOR: Menggunakan Eloquent untuk mengaktifkan properti mutator & casts
                        $ajuan->update([
                            'hari'        => $hari,
                            'jam_mulai'   => $start,
                            'jam_selesai' => $end,
                            'status'      => 'disetujui'
                        ]);

                        $foundSlot = true;
                        $countSetuju++;
                        break;
                    }
                }
                if ($foundSlot) break;
            }

            // Jika semua slot penuh, maka ajuan otomatis ditolak
            if (!$foundSlot) {
                // REFAKTOR: Menggunakan instansi objek model saat ini (Konsisten & Clean)
                $ajuan->update([
                    'status' => 'ditolak'
                ]);
                $countTolak++;
            }
        }

        return redirect()->back()->with('success', "Generate Selesai! $countSetuju Ajuan Disetujui, $countTolak Ajuan Ditolak.");
    }
}
