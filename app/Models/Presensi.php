<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $fillable = [
        'user_username',
        'ajuan_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterlambatan_menit',
    ];
}
