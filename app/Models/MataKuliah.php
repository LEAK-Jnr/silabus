<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk membuka "kunci" kolom di database
    protected $fillable = [
        'prodi_id',
        'kode_mk',
        'nama_mk',
        'sks',
        'semester',
        'skor_prioritas',
        'spesifikasi',
        'kategori'
    ];

    // Relasi ke Prodi agar Admin bisa melihat nama prodi di tabel
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}