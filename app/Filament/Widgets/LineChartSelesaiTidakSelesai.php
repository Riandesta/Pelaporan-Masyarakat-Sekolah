<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pengaduan;

class LineChartSelesaiTidakSelesai extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pengaduan Selesai & Tidak Selesai (Line Chart)';

    protected function getData(): array
    {
        $statusCounts = Pengaduan::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $labels = ['Selesai', 'Tidak Selesai'];
        $data = [
            $statusCounts->get('selesai', 0),
            $statusCounts->get('tidak_selesai', 0),
        ];

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Pengaduan',
                    'data' => $data,
                    'backgroundColor' => ['#9966FF', '#FF9F40'],
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
