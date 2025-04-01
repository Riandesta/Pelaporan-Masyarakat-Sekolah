<?php

namespace App\Filament\Resources\ValidasiKelasResource\Pages;

use App\Filament\Resources\ValidasiKelasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListValidasiKelas extends ListRecords
{
    protected static string $resource = ValidasiKelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
