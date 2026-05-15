<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ajuan extends Model
{
    protected $fillable = [
        'kode_mk',
        'kode_kelas',
        'username_dosen',
        'ruangan_id',
        'status',
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
        return $this->belongsTo(User::class, 'username_dosen', 'username');
    }
    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }
}
