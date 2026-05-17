<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model
{
    public function index() {
        return view('dosen.laporan.index');
    }
}
