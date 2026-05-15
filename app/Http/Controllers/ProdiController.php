<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ajuan;
use App\Models\User;

class ProdiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $query = Ajuan::with(['mataKuliah', 'kelas', 'dosen', 'ruangan']);
        $dosenQuery = User::where('role', 'dosen');
        $ruangans = \App\Models\Ruangan::all();
        $matakuliahs = \App\Models\MataKuliah::query();

        if ($user->role === 'prodi') {
            $query->whereHas('mataKuliah', function($q) use ($user) {
                $q->where('prodi_id', $user->prodi_id);
            });
            $dosenQuery->where('prodi_id', $user->prodi_id);
            $matakuliahs->where('prodi_id', $user->prodi_id);
        }

        $ajuans = $query->get();
        $dosenPengampu = $dosenQuery->get();
        $matakuliahs = $matakuliahs->get();
        $kelases = \App\Models\Kelas::all();

        return view('prodi.ajuan.index', compact('ajuans', 'dosenPengampu', 'ruangans', 'matakuliahs', 'kelases'));
    }
    public function store()
    {
        // Validasi input
        $validated = request()->validate([
            'kode_mk' => 'required|exists:mata_kuliahs,id',
            'kode_kelas' => 'required|exists:kelas,id',
            'username_dosen' => 'required|exists:users,username',
            'ruangan_id' => 'required|exists:ruangans,id', // Tambahkan validasi untuk ruangan_id
        ]);


        // Simpan ajuan baru
        Ajuan::create([
            'kode_mk' => $validated['kode_mk'],
            'kode_kelas' => $validated['kode_kelas'],
            'username_dosen' => $validated['username_dosen'],
            'ruangan_id' => $validated['ruangan_id'],
            'status' => 'menunggu',
        ]);

        return redirect()->route('prodi.ajuan')->with('success', 'Ajuan berhasil dibuat!');
    }

    public function update(Request $request, $id) {
        // Cek status 'disetujui'
        $ajuan = \App\Models\Ajuan::findOrFail($id);
        if ($ajuan->status === 'disetujui') {
            return redirect()->route('prodi.ajuan')->with('error', 'Ajuan yang sudah "disetujui" tidak dapat dirubah!');
        }
         // 3. Jalankan validasi input form baru
        $request->validate([
            'kode_mk'        => 'required|exists:mata_kuliahs,id',
            'kode_kelas'     => 'required|exists:kelas,id',
            'username_dosen' => 'required|exists:users,username',
            'ruangan_id'     => 'required|exists:ruangans,id',
            'status'          => 'in:menunggu,disetujui,ditolak',
        ]);

        $ajuan->update([
            'kode_mk' => $request->kode_mk,
            'kode_kelas' => $request->kode_kelas,
            'username_dosen' => $request->username_dosen,
            'ruangan_id' => $request->ruangan_id,
            'status' => $request->status,
        ]);

        return redirect()->route('prodi.ajuan')->with('success', 'Ajuan berhasil diperbarui!');

    }

    public function destroy($id)
    {
        $ajuan = \App\Models\Ajuan::findOrFail($id);
            if ($ajuan->status === 'disetujui') {
                return redirect()->route('prodi.ajuan')->with('error', 'Ajuan yang sudah "disetujui" tidak dapat dihapus!');
            }
        $ajuan->delete();
        
        return redirect()->route('prodi.ajuan')->with('success', 'Ajuan berhasil dihapus!');
    }
}
