<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ajuan extends Model
{
    protected $fillable = [
        'kode_mk',
        'kode_kelas',
        'user_username',
        'ruangan_id',
        'pekan', 
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    protected $casts = [
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];
    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_username', 'username');
    }
    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function presensi()
    {
        return $this->hasOne(Presensi::class, 'ajuan_id');
    }
}
