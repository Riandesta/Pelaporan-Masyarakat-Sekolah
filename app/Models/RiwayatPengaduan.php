<?php

namespace App\Models;

use App\Models\Pengaduan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatPengaduan extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'riwayat_pengaduan';

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Akses status dari tabel pengaduans
    public function getStatusAttribute()
    {
        return $this->pengaduan->status;
    }
}
