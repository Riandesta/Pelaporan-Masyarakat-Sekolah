<?php

namespace App\Models;

use App\Models\User;
use App\Models\JenisLaporan;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\UploadedFile; // Import UploadedFile
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk Storage

class Pengaduan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = true;

    // Daftar status yang valid
    public const STATUS_PENDING = 'pending';
    public const STATUS_PELAPORAN_KELAS = 'pelaporan_kelas';
    public const STATUS_PELAPORAN_LAB = 'pelaporan_lab';
    public const STATUS_PROSES = 'proses';
    public const STATUS_SELESAI = 'selesai';
    public const STATUS_TIDAK_SELESAI = 'tidak_selesai';
    public const STATUS_DITOLAK = 'ditolak';
    public const STATUS_DALAM_PROSES = 'dalam_proses';

    /**
     * Relasi ke model JenisLaporan.
     */
    public function jenisLaporan(): BelongsTo
    {
        return $this->belongsTo(JenisLaporan::class, 'id_jenis_laporan');
    }

    /**
     * Relasi ke model User (pelapor).
     */
    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mengatur status pengaduan.
     */
    public function setStatus(string $status): void
    {
        $validStatuses = [
            self::STATUS_PENDING,
            self::STATUS_PELAPORAN_KELAS,
            self::STATUS_PELAPORAN_LAB,
            self::STATUS_PROSES,
            self::STATUS_SELESAI,
            self::STATUS_TIDAK_SELESAI,
            self::STATUS_DITOLAK,
            self::STATUS_DALAM_PROSES,
        ];

        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException("Invalid status: {$status}");
        }

        $this->update(['status' => $status]);
        $this->touch(); // Memastikan updated_at diperbarui
    }

    /**
     * Mengajukan pengaduan berdasarkan jenis laporan.
     */
    public function submit(): void
    {
        $jenisLaporan = $this->jenisLaporan;

        if (!$jenisLaporan) {
            throw new \Exception("Jenis laporan tidak ditemukan.");
        }

        // Tentukan status berdasarkan nama jenis laporan
        $status = strtolower($jenisLaporan->nama_jenis_laporan) === 'kelas'
            ? self::STATUS_PELAPORAN_KELAS
            : self::STATUS_PELAPORAN_LAB;

        $this->setStatus($status);
    }

    /**
     * Mutator untuk atribut foto.
     */
    public function setFotoAttribute($value)
    {
        if ($value instanceof UploadedFile) {
            // Hapus foto lama jika ada
            if ($this->foto && Storage::disk('public')->exists($this->foto)) {
                Storage::disk('public')->delete($this->foto);
            }

            // Simpan foto baru
            $this->attributes['foto'] = $value->store('pengaduan-foto', 'public');
        } elseif (is_string($value)) {
            $this->attributes['foto'] = $value;
        }
    }
}
