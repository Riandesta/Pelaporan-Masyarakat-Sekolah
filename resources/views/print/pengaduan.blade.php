<div>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Print Pengaduan</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .content {
                line-height: 1.6;
            }
            .footer {
                margin-top: 20px;
                text-align: right;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Riwayat Pengaduan</h1>
            </div>
            <div class="content">
                <p><strong>Judul:</strong> {{ $pengaduan->judul }}</p>
                <p><strong>Deskripsi:</strong> {{ $pengaduan->deskripsi }}</p>
                <p><strong>Status:</strong> {{ $pengaduan->status }}</p>
                <p><strong>Tanggal Dibuat:</strong> {{ $pengaduan->created_at->format('d M Y H:i') }}</p>
                @if ($pengaduan->foto)
                    <img src="{{ public_path('storage/pengaduan-foto/' . $pengaduan->foto) }}" alt="Foto Bukti" style="max-width: 100%; height: auto;">
                @endif
            </div>
            <div class="footer">
                <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
            </div>
        </div>
    </body>
    </html>
</div>
