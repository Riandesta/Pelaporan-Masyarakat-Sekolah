<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request; // Gunakan instance Request, bukan facade

class PengaduanController extends Controller
{
    public function printAll(Request $request) // Gunakan instance Request
    {
        // Mengambil query builder berdasarkan filter yang diterapkan
        $query = Pengaduan::query();

        // Terapkan filter status jika ada
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        // Terapkan filter tanggal jika ada
        if ($request->has('from') && $request->has('until')) {
            $query->whereBetween('created_at', [$request->input('from'), $request->input('until')]);
        }

        // Ambil data
        $pengaduan = $query->get();

        // Kirim data ke view
        $data = [
            'pengaduan' => $pengaduan,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('print.all-pengaduan', $data);

        return $pdf->stream('all-pengaduan.pdf');
    }
}
