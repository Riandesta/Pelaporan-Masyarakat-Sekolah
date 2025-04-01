<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pengaduan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Services\PengaduanService;
use Illuminate\Support\Facades\Log;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ValidasiLabResource\Pages;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;

class ValidasiLabResource extends Resource
{
    protected static ?string $model = Pengaduan::class;
    protected static ?string $navigationTitle = 'Validasi Lab';
    protected static ?string $navigationGroup = 'Validasi Lab';
    protected static ?string $label = 'Validasi Lab';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')->searchable(),
                Tables\Columns\TextColumn::make('status')->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pelaporan_lab' => 'Pelaporan Lab',
                        'proses' => 'Proses',
                        'ditolak' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('terima')
                    ->label('Terima')
                    ->action(function ($record) {
                        $record->setStatus(Pengaduan::STATUS_PROSES);

                        Notification::make()
                            ->title('Laporan Diterima!')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === Pengaduan::STATUS_PELAPORAN_LAB),

                Tables\Actions\Action::make('tolak')
                    ->label('Tolak')
                    ->action(function ($record) {
                        $record->setStatus(Pengaduan::STATUS_DITOLAK);

                        Notification::make()
                            ->title('Laporan Ditolak!')
                            ->danger()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === Pengaduan::STATUS_PELAPORAN_LAB),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', Pengaduan::STATUS_PELAPORAN_LAB);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListValidasiLabs::route('/'),
            'create' => Pages\CreateValidasiLab::route('/create'),
            'edit' => Pages\EditValidasiLab::route('/{record}/edit'),
        ];
    }
}
