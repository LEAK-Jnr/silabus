<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class kelas extends Model
{
    protected $table = 'kelas'; // Karena nama tabel 'kelas' (bahasa Indonesia)

    protected $fillable = [
        'kode_kelas',
        'reguler',
        'prodi_id',
    ];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }
}
