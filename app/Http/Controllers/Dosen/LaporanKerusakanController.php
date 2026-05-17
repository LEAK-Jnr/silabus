<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanKerusakanController extends Controller
{
    public function index() {
        return view('dosen.laporan.index');
    }
}
