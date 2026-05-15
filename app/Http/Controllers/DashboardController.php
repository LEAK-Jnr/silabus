<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            return view('dashboard');
        } elseif ($role === 'prodi') {
            return redirect()->route('prodi.ajuan');
        } elseif ($role === 'dosen') {
            return redirect()->route('dosen.jadwal');
        }
    }
}
