<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::all();
        return view('admin.ruangan.index', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'spesifikasi' => 'required|in:standar,tinggi',
        ]);

        Ruangan::create($request->all());

        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return redirect()->back()->with('success', 'Ruangan berhasil dihapus!');
    }
}