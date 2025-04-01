<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pengaduan;

class LineChartKelasLab extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pengaduan Kelas & Lab (Line Chart)';

    protected function getData(): array
    {
        $statusCounts = Pengaduan::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $labels = ['Pelaporan Kelas', 'Pelaporan Lab'];
        $data = [
            $statusCounts->get('pelaporan_kelas', 0),
            $statusCounts->get('pelaporan_lab', 0),
        ];

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Pengaduan',
                    'data' => $data,
                    'backgroundColor' => ['#36A2EB', '#FFCE56'],
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
