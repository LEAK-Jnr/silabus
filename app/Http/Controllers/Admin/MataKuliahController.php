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
            'semester' => 'required|integer|min:1',
            'kategori' => 'required|in:teori,praktik,teori-praktik',
            'spesifikasi' => 'required|in:tinggi,standar',
        ]);

        $validated = $this->calculatePriorityScore($validated);

        MataKuliah::create($validated);

        return redirect()->back()->with('success', 'Mata Kuliah berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $matakuliah = MataKuliah::findOrFail($id);

        $validated = $request->validate([
            'nama_mk' => 'required',
            'prodi_id' => 'required|exists:prodis,id',
            'sks' => 'required|integer',
            'semester' => 'required|integer|min:1',
            'kategori' => 'required|in:teori,praktik,teori-praktik',
            'spesifikasi' => 'required|in:tinggi,standar',
        ]);

        $validated = $this->calculatePriorityScore($validated);

        $matakuliah->update($validated);

        return redirect()->back()->with('success', 'Mata Kuliah berhasil diperbarui!');
    }

    /**
     * Kalkulasi Skor Prioritas dan remap Kategori
     */
    private function calculatePriorityScore(array $validated)
    {
        $skor = 0;
        
        // Logic SKS
        $skor += ($validated['sks'] < 3) ? 10 : 30;

        // Logic Semester
        if ($validated['semester'] <= 3) {
            $skor += 30;
        } elseif ($validated['semester'] >= 4 && $validated['semester'] <= 5) {
            $skor += 15;
        } else {
            $skor += 5;
        }

        // Logic Kategori & Re-map
        if ($validated['kategori'] === 'praktik') {
            $skor += 30;
            $validated['kategori'] = 'praktikum';
        } elseif ($validated['kategori'] === 'teori-praktik') {
            $skor += 20;
            $validated['kategori'] = 'teori_praktikum';
        } elseif ($validated['kategori'] === 'teori') {
            $skor += 5;
        }

        $validated['skor_prioritas'] = $skor;

        return $validated;
    }
    
    public function destroy($id)
    {
        MataKuliah::findOrFail($id)->softDelete();
        return redirect()->back()->with('success', 'Mata Kuliah berhasil dihapus!');
    }
}