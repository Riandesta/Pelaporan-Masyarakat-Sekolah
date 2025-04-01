<?php

namespace App\Filament\Resources\RiwayatPengaduanResource\Pages;

use App\Filament\Resources\RiwayatPengaduanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRiwayatPengaduans extends ManageRecords
{
    protected static string $resource = RiwayatPengaduanResource::class;
    protected function getHeaderActions(): array
    {
        return [];
    }
}
