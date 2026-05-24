<?php

namespace App\Http\Controllers\Prodi;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Ajuan;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\MataKuliah;
use App\Models\Kelas;

class ProdiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // 1. Inisialisasi Query dasar
        $query = Ajuan::with(['mataKuliah', 'kelas', 'dosen', 'ruangan']);
        $dosenQuery = User::where('role', 'dosen');
        $matakuliahQuery = MataKuliah::query();
        $kelasQuery = Kelas::query(); //  query builder untuk kelas
        $ruangans = Ruangan::all();
        $pekans = range(1, 14);

        // 4. Filtering ketat jika role-nya adalah 'prodi'
        if ($user->role === 'prodi') {
            // Filter Ajuan: Hanya tampilkan ajuan yang Mata Kuliahnya milik prodi ybs
            $query->whereHas('mataKuliah', function($q) use ($user) {
                $q->where('prodi_id', $user->prodi_id);
            });

            // Filter Dosen: Hanya dosen di prodi ybs
            $dosenQuery->where('prodi_id', $user->prodi_id);

            // Filter Mata Kuliah: Hanya MK milik prodi ybs
            $matakuliahQuery->where('prodi_id', $user->prodi_id);

            // --- TAMBAHAN: Filter Kelas ---
            // Agar datalist kelas tidak memunculkan kelas dari prodi lain
            $kelasQuery->where('prodi_id', $user->prodi_id);
        }

        // 5. Eksekusi Get Data
        $ajuans = $query->orderBy('pekan', 'asc')->get(); 
        $dosenPengampu = $dosenQuery->get();
        $matakuliahs = $matakuliahQuery->get();
        $kelases = $kelasQuery->get(); // Ambil hasil filter kelas

        return view('prodi.ajuan.index', compact(
            'ajuans', 
            'dosenPengampu', 
            'ruangans', 
            'matakuliahs', 
            'kelases', 
            'pekans'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk'        => 'required|exists:mata_kuliahs,id',
            'kode_kelas'     => 'required|exists:kelas,id',
            'user_username' => 'required|exists:users,username',
            'ruangan_id'     => 'required|exists:ruangans,id',
            'pekan'          => 'required|integer|min:1|max:14', // Koreksi validasi max:14
        ]);

        Ajuan::create(array_merge($validated, [
            'status' => 'menunggu'
        ]));

        return redirect()->route('prodi.ajuan')->with('success', 'Ajuan Pekan ke-' . $request->pekan . ' berhasil dibuat!');
    }

   public function update(Request $request, $id) 
{
    $ajuan = Ajuan::findOrFail($id);

    if ($ajuan->status === 'disetujui') {
        return redirect()->route('prodi.ajuan')->with('error', 'Status "disetujui" sudah dikunci!');
    }

    // Tulis aturan validasi
    $validated = $request->validate([
        'kode_mk'        => 'required|exists:mata_kuliahs,id',
        'kode_kelas'     => 'required|exists:kelas,id',
        'user_username' => 'required|exists:users,username',
        'ruangan_id'     => 'required|exists:ruangans,id',
        'pekan'          => 'required|integer|min:1|max:14', 
    ], [
        // SUNTIKKAN PESAN KUSTOM DI SINI:
        'pekan.max' => 'Pekan tidak boleh melebihi 14!',
        'pekan.min' => 'Pekan minimal berangka 1!',
    ]);

    // Jalankan update
    $ajuan->update($validated);

    return redirect()->route('prodi.ajuan')->with('success', 'Perubahan pekan ke-' . $request->pekan . ' berhasil disimpan!');
}



    public function destroy($id)
    {
        $ajuan = Ajuan::findOrFail($id);

        if ($ajuan->status === 'disetujui') {
            return redirect()->route('prodi.ajuan')->with('error', 'Data yang sudah disetujui tidak bisa dihapus!');
        }

        $ajuan->delete();
        return redirect()->route('prodi.ajuan')->with('success', 'Data berhasil dihapus.');
    }
}
