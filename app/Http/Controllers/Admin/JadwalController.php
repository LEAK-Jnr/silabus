<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Ajuan;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal dengan filter pekan
     */
    public function index(Request $request)
    {
        // Ambil pekan dari request, default ke pekan 1
        $pekanAktif = $request->get('pekan', 1);

        $ajuans = Ajuan::with(['mataKuliah', 'kelas', 'dosen', 'ruangan'])
            ->where('pekan', $pekanAktif)
            // Gunakan urutan yang logis: Hari dulu, baru Jam Mulai
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
    // 1. Definisikan slot (Gunakan format detik :00 secara eksplisit)
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

    // Ambil ajuan menunggu dengan skor prioritas
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

        if (isset($slotWaktu[$reguler])) {
            foreach ($slotWaktu[$reguler]['hari'] as $hari) {
                foreach ($slotWaktu[$reguler]['jam'] as $jam) {
                    
                    // Gunakan format string absolut untuk jam
                    $start = $jam[0];
                    $end   = $jam[1];

                    // Cek Bentrok
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
                        // UPDATE MENGGUNAKAN QUERY BUILDER UNTUK MENGHINDARI BUG MODEL PADA BARIS PERTAMA
                        DB::table('ajuans')->where('id', $ajuan->id)->update([
                            'hari' => $hari,
                            'jam_mulai' => $start,
                            'jam_selesai' => $end,
                            'status' => 'disetujui',
                            'updated_at' => now()
                        ]);

                        $foundSlot = true;
                        $countSetuju++; // Increment nilai
                        break;
                    }
                }
                if ($foundSlot) break;
            }
        }

        if (!$foundSlot) {
            DB::table('ajuans')->where('id', $ajuan->id)->update([
                'status' => 'ditolak',
                'updated_at' => now()
            ]);
            $countTolak++;
        }
    }

    return redirect()->back()->with('success', "Generate Selesai! $countSetuju Ajuan Disetujui, $countTolak Ajuan Ditolak.");
  }
}