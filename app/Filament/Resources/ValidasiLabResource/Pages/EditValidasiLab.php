<?php

namespace App\Filament\Resources\ValidasiLabResource\Pages;

use App\Filament\Resources\ValidasiLabResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditValidasiLab extends EditRecord
{
    protected static string $resource = ValidasiLabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
