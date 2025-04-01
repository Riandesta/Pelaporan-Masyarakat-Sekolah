<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pengaduan;

class BarChartPengaduans extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pengaduan (Bar Chart)';

    protected function getData(): array
    {
        $statusCounts = Pengaduan::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $labels = ['Pending', 'Proses', 'Ditolak'];
        $data = [
            $statusCounts->get('pending', 0),
            $statusCounts->get('proses', 0),
            $statusCounts->get('ditolak', 0),
        ];

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Pengaduan',
                    'data' => $data,
                    'backgroundColor' => ['#FF6384', '#4BC0C0', '#C9CBCF'],
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
