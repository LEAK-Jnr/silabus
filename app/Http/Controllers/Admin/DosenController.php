<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    public function index()
    {
        $dosens = User::with('prodi')->where('role', 'dosen')->get();
        $prodis = Prodi::all();
        
        return view('admin.dosen.index', compact('dosens', 'prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'nullable|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'prodi_id' => 'nullable|exists:prodis,id',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
            'prodi_id' => $request->prodi_id,
        ]);

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil ditambahkan.');
    }
    
    public function update(Request $request, User $dosen)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($dosen->id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($dosen->id)],
            'password' => 'nullable|string|min:6',
            'prodi_id' => 'nullable|exists:prodis,id',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'prodi_id' => $request->prodi_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $dosen->update($data);

        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil diperbarui.');
    }

    public function destroy(User $dosen)
    {
        $dosen->delete();
        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil dihapus.');
    }
}
