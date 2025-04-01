<?php

namespace App\Filament\Resources\JenisLaporanResource\Pages;

use App\Filament\Resources\JenisLaporanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisLaporans extends ListRecords
{
    protected static string $resource = JenisLaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
