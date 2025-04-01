<?php

namespace App\Filament\Resources\ValidasiKelasResource\Pages;

use App\Filament\Resources\ValidasiKelasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditValidasiKelas extends EditRecord
{
    protected static string $resource = ValidasiKelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
