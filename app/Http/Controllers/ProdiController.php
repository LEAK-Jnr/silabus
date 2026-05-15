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
        
        $query = Ajuan::with(['mataKuliah', 'kelas', 'dosen']);
        $dosenQuery = User::where('role', 'dosen');

        if ($user->role === 'prodi') {
            $query->whereHas('mataKuliah', function($q) use ($user) {
                $q->where('prodi_id', $user->prodi_id);
            });
            $dosenQuery->where('prodi_id', $user->prodi_id);
        }

        $ajuans = $query->get();
        $dosenPengampu = $dosenQuery->get();

        return view('prodi.ajuan.index', compact('ajuans', 'dosenPengampu'));
    }
    public function store()
    {
        // Validasi input
        $validated = request()->validate([
            'kode_mk' => 'required|exists:mata_kuliahs,id',
            'kode_kelas' => 'required|exists:kelas,id',
            'username_dosen' => 'required|exists:users,username',
        ]);

        // Simpan ajuan baru
        Ajuan::create([
            'kode_mk' => $validated['kode_mk'],
            'kode_kelas' => $validated['kode_kelas'],
            'username_dosen' => $validated['username_dosen'],
            'status' => 'menunggu',
        ]);

        return redirect()->route('prodi.ajuan')->with('success', 'Ajuan berhasil dibuat!');
    }
}
