<?php

namespace App\Filament\Resources\ValidasiLabResource\Pages;

use App\Filament\Resources\ValidasiLabResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListValidasiLabs extends ListRecords
{
    protected static string $resource = ValidasiLabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
