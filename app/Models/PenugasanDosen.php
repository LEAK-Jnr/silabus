<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenugasanDosen extends Model
{
    protected  $fillable = [
        'prodi_id',
        'kd_dosen',
        'matakuliah_id',
        'kelas_id'
    ];

    public function prodi() : BelongsTo {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function dosen() : BelongsTo {
        return $this->belongsTo(User::class, 'kd_dosen', 'username');
    }

    public function mataKuliah() : BelongsTo {
        return $this->belongsTo(MataKuliah::class, 'matakuliah_id');
    }

    public function kelas() : BelongsTo {
        return $this->belongsTo(kelas::class, 'kelas_id');
    }
}
