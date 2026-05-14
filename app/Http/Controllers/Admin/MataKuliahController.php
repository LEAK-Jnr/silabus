<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Prodi;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $matakuliahs = MataKuliah::with('prodi')->get();
        $prodis = Prodi::all();
        return view('admin.matakuliah.index', compact('matakuliahs', 'prodis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'kode_mk' => 'required|unique:mata_kuliahs',
        'nama_mk' => 'required',
        'prodi_id' => 'required|exists:prodis,id',
        'sks' => 'required|integer',
        'skor_prioritas' => 'required|integer|min:1|max:100',
        'spesifikasi' => 'required|in:tinggi,standar',
        ]);

        MataKuliah::create($validated);

        return redirect()->back()->with('success', 'Mata Kuliah berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        MataKuliah::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Mata Kuliah berhasil dihapus!');
    }
}