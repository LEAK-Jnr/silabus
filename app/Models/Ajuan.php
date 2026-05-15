<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ajuan extends Model
{
    protected $table = 'ajuan';

    protected $fillable = [
        'kode_mk',
        'kode_kelas',
        'username_dosen',
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
}
