<div>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Print All Pengaduan</title>
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
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f4f4f4;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Pengaduan Masyarakat SMK IGASAR PINDAD</h1>
            </div>
            <div class="content">
                <table>
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengaduan as $item)
                            <tr>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="footer">
                <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
            </div>
        </div>
    </body>
    </html>
</div>
