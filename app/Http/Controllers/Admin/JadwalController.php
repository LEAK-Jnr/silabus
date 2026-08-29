<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Ajuan;
use App\Models\Presensi;
use Illuminate\Support\Facades\DB;
use PDF;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal dengan filter pekan
     */
    public function index(Request $request)
    {
        $pekanAktif = $request->get('pekan', 1);
        $ruanganId = $request->get('ruangan_id');

        $query = Ajuan::with(['mataKuliah', 'kelas', 'dosen', 'ruangan', 'presensi'])
            ->where('pekan', $pekanAktif)
            ->where('status', '!=', 'ditolak');

        if ($ruanganId) {
            $query->where('ruangan_id', $ruanganId);
        }

        $ajuans = $query->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();
            
        $ruangans = \App\Models\Ruangan::all();

        // Force clear view cache to ensure the null-safe operators are applied
        \Illuminate\Support\Facades\Artisan::call('view:clear');

        return view('admin.jadwal.index', compact('ajuans', 'pekanAktif', 'ruangans', 'ruanganId'));
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

        $ajuans = Ajuan::with(['kelas', 'mataKuliah'])
            ->where('ajuans.status', 'menunggu')
            ->join('mata_kuliahs', 'ajuans.kode_mk', '=', 'mata_kuliahs.id')
            ->join('prodis', 'mata_kuliahs.prodi_id', '=', 'prodis.id')
            ->select('ajuans.*')
            ->selectRaw('(prodis.bobot_prioritas * 5 + mata_kuliahs.skor_prioritas) as total_skor')
            ->orderBy('total_skor', 'desc')
            ->get();

        $countSetuju = 0;
        $countTolak = 0;

        foreach ($ajuans as $ajuan) {
            if (!$ajuan->kelas) {
                // Lewati ajuan jika data kelas tidak valid/terhapus
                $ajuan->update(['status' => 'ditolak']);
                $countTolak++;
                continue;
            }
            $regulerRaw = strtoupper($ajuan->kelas->reguler); 
            $reguler = trim(str_replace('REGULER', '', $regulerRaw));
            $foundSlot = false;

            if (!isset($slotWaktu[$reguler])) {
                continue;
            }

            // Tentukan ruangan yang diizinkan berdasarkan spesifikasi MK
            $spesifikasi = $ajuan->mataKuliah ? $ajuan->mataKuliah->spesifikasi : 'sedang';
            $allowedRooms = ($spesifikasi === 'tinggi') ? [3] : [1, 2];

            foreach ($slotWaktu[$reguler]['hari'] as $hari) {
                foreach ($slotWaktu[$reguler]['jam'] as $jam) {
                    [$start, $end] = $jam;

                    foreach ($allowedRooms as $ruanganId) {
                        // Cek ketersediaan/bentrok pada slot waktu
                        $isOccupied = Ajuan::where('pekan', $ajuan->pekan)
                            ->where('hari', $hari)
                            ->where('jam_mulai', $start)
                            ->where('status', 'disetujui')
                            ->where(function($q) use ($ajuan, $ruanganId) {
                                $q->where('user_username', $ajuan->user_username)
                                  ->orWhere('kode_kelas', $ajuan->kode_kelas)
                                  ->orWhere('ruangan_id', $ruanganId);
                            })->exists();

                        if (!$isOccupied) {
                            // REFAKTOR: Menggunakan Eloquent untuk mengaktifkan properti mutator & casts
                            $ajuan->update([
                                'hari'        => $hari,
                                'jam_mulai'   => $start,
                                'jam_selesai' => $end,
                                'ruangan_id'  => $ruanganId,
                                'status'      => 'disetujui'
                            ]);

                            $foundSlot = true;
                            $countSetuju++;
                            break;
                        }
                    }
                    if ($foundSlot) break;
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
    public function exportPdf(Request $request) {
        $pekanAktif = $request->get('pekan', 1);

        $ajuans = Ajuan::with(['mataKuliah', 'kelas', 'dosen', 'ruangan', 'presensi'])
            ->where('pekan', $pekanAktif)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        $pdf = PDF::loadView('admin.jadwal.pdf', compact('ajuans', 'pekanAktif'))->setPaper('a4', 'landscape');

        return $pdf->download("jadwal-pekan-{$pekanAktif}.pdf");
    }
    public function exportPdfAll() {
        // Ambil semua ajuan dan kelompokkan berdasarkan pekan
        $ajuans = Ajuan::with(['mataKuliah', 'kelas', 'dosen', 'ruangan', 'presensi'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        $ajuansGrouped = $ajuans->groupBy('pekan');

        $pdf = PDF::loadView('admin.jadwal.pdf-all', compact('ajuansGrouped'))->setPaper('a4', 'landscape');

        return $pdf->download("jadwal-kuliah-massal-pekan-1-14.pdf");
    }

    public function checkIn(Request $request, Ajuan $ajuan)
    {
        $now = now();
        $currentTime = $now->format('H:i:s');
        
        $hariMap = [
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6,
            'Minggu' => 7
        ];
        
        if (isset($hariMap[$ajuan->hari]) && $now->format('N') != $hariMap[$ajuan->hari]) {
            return back()->with('error', 'Gagal check-in. Jadwal ini hanya untuk hari ' . $ajuan->hari . '.');
        }
        
        $jamMulai = \Carbon\Carbon::parse($ajuan->jam_mulai);
        $earliestCheckIn = $jamMulai->copy()->subMinutes(15);
        $currentCarbon = \Carbon\Carbon::parse($currentTime);
        
        if ($currentCarbon->lessThan($earliestCheckIn)) {
            return back()->with('error', 'Terlalu cepat untuk check-in. Check-in bisa dilakukan mulai 15 menit sebelum jadwal.');
        }
        
        $jamSelesai = \Carbon\Carbon::parse($ajuan->jam_selesai);
        // Hapus batasan No-Show backend agar Admin bisa melakukan check-in terlambat sekalipun
        // if ($currentCarbon->greaterThan($jamSelesai)) {
        //     return back()->with('error', 'Gagal check-in. Jadwal perkuliahan sudah berakhir (Status: No-Show).');
        // }
        
        $minutesLate = $jamMulai->diffInMinutes($currentCarbon, false);
        
        $status = 'hadir';
        $keterlambatanMenit = 0;
        
        if ($minutesLate > 20) {
            $status = 'terlambat';
            $keterlambatanMenit = $minutesLate - 20;
        }
        
        Presensi::updateOrCreate(
            ['ajuan_id' => $ajuan->id, 'tanggal' => $now->toDateString()],
            [
                'user_username' => $ajuan->user_username,
                'jam_masuk' => $currentTime,
                'status' => $status,
                'keterlambatan_menit' => $keterlambatanMenit
            ]
        );
        
        return back()->with('success', 'Berhasil Check-in.');
    }

    public function updatePlot(Request $request, Ajuan $ajuan)
    {
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'ruangan_id' => 'nullable|exists:ruangans,id',
        ]);

        $ajuan->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ruangan_id' => $request->ruangan_id,
        ]);

        return back()->with('success', 'Jadwal plot berhasil diubah.');
    }

    public function checkOut(Request $request, Ajuan $ajuan)
    {
        $now = now();
        
        $presensi = \App\Models\Presensi::where('ajuan_id', $ajuan->id)
                                        ->where('tanggal', $now->toDateString())
                                        ->first();
                                        
        if (!$presensi) {
            return back()->with('error', 'Belum melakukan Check-in.');
        }
        
        $presensi->update([
            'jam_keluar' => $now->format('H:i:s')
        ]);
        
        return back()->with('success', 'Berhasil Check-out.');
    }

    public function rollback(){
        // dd("Function Rollback is called");
        DB::beginTransaction();
        try {
            Ajuan::query()
            ->where('status', 'disetujui')
            ->orWhere('status', 'ditolak')
            ->update([
                'status' => 'menunggu',
                'hari' => null,
                'jam_mulai' => null,
                'jam_selesai' => null,
                'ruangan_id' => null
            ]);
            DB::commit();
            return back()->with('success', 'Semua ajuan berhasil di-rollback ke status menunggu.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat melakukan rollback. | Error: ' . $th->getMessage());
        }
    }
}
