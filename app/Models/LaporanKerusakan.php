<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model
{
    protected $fillable = [
        'ruangan_id',
        'user_username',
        'nama_barang',
        'deskripsi_kerusakan',
        'tingkat_kerusakan',
        'status_perbaikan',
        'catatan_perbaikan',
    ];
}
