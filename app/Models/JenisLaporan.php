<?php

namespace App\Models;

use App\Models\Pengaduan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class JenisLaporan extends Model
{

    protected $guarded = [];

    // Casting untuk kolom JSON
    protected $casts = [
        'handler_role' => 'array',
    ];

    // Relasi dengan pengaduan
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_jenis_laporan');
    }
}
