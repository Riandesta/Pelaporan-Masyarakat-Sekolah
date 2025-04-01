<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Proses;
use Filament\Forms\Form;
use App\Models\Pengaduan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProsesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProsesResource\RelationManagers;

class ProsesResource extends Resource
{
    protected static ?string $model = Pengaduan::class;
    protected static ?string $navigationTitle = 'Proses Pengaduan';
    protected static ?string $navigationGroup = 'Proses Pengaduan';
    protected static ?string $label = 'Proses Pengaduan';
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
                        'proses' => 'Proses',
                        'selesai' => 'Selesai',
                        'tidak_selesai' => 'Tidak Selesai',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('selesai')
                    ->label('Selesai')
                    ->action(function ($record) {
                        $record->setStatus(Pengaduan::STATUS_SELESAI);

                        Notification::make()
                            ->title('Laporan Diselesaikan!')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === Pengaduan::STATUS_PROSES),

                    Tables\Actions\Action::make('dalam_proses')
                        ->label('Dalam Proses')
                        ->action(function ($record) {
                            $record->setStatus(Pengaduan::STATUS_DALAM_PROSES);

                            Notification::make()
                                ->title('Laporan Masih Dalam Proses !')
                                ->success()
                                ->send();
                        })
                        ->visible(fn ($record) => $record->status === Pengaduan::STATUS_PROSES),

                Tables\Actions\Action::make('tidak_selesai')
                    ->label('Tidak Selesai')
                    ->action(function ($record) {
                        $record->setStatus(Pengaduan::STATUS_TIDAK_SELESAI);

                        Notification::make()
                            ->title('Laporan Tidak Selesai!')
                            ->warning()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === Pengaduan::STATUS_PROSES),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', Pengaduan::STATUS_PROSES);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProses::route('/'),
            'create' => Pages\CreateProses::route('/create'),
            'edit' => Pages\EditProses::route('/{record}/edit'),
        ];
    }
}
