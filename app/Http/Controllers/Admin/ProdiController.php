<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::all();
        return view('admin.prodi.index', compact('prodis'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'bobot_prioritas' => 'required|integer|max:100',
        ]);

        Prodi::create([
            'nama_prodi' => $request->nama_prodi,
            'bobot_prioritas' => $request->bobot_prioritas,
        ]);

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil ditambahkan.');
    }
    
    public function update(Request $request, Prodi $prodi)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'bobot_prioritas' => 'required|integer|max:100',

        ]);

        $prodi->update([
            'nama_prodi' => $request->nama_prodi,
            'bobot_prioritas' => $request->bobot_prioritas,
        ]);

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil diperbarui.');
    }
    public function destroy(Prodi $prodi)
    {
        $prodi->delete();
        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil dihapus.');
    }
}
