<?php

namespace App\Services;

use App\Models\Pengaduan;
use Illuminate\Support\Facades\Notification;

class PengaduanService
{
    public function submit(Pengaduan $pengaduan): void
    {
        $pengaduan->submit();

        Notification::make()
            ->title('Laporan Diajukan!')
            ->success()
            ->send();
    }

    public function accept(Pengaduan $pengaduan): void
    {
        $pengaduan->setStatus(Pengaduan::STATUS_PROSES);

        Notification::make()
            ->title('Laporan Diterima!')
            ->success()
            ->send();
    }

    public function reject(Pengaduan $pengaduan): void
    {
        $pengaduan->setStatus(Pengaduan::STATUS_DITOLAK);

        Notification::make()
            ->title('Laporan Ditolak!')
            ->danger()
            ->send();
    }

    public function complete(Pengaduan $pengaduan): void
    {
        $pengaduan->update([
            'status' => Pengaduan::STATUS_SELESAI,
            'tanggal_selesai' => now(),
        ]);

        Notification::make()
            ->title('Laporan Diselesaikan!')
            ->success()
            ->send();
    }
}
