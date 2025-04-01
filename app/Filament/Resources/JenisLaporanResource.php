<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\JenisLaporan;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JenisLaporanResource\Pages;
use App\Filament\Resources\JenisLaporanResource\RelationManagers;

class JenisLaporanResource extends Resource
{
    protected static ?string $model = JenisLaporan::class;
    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_jenis_laporan')
                ->label('Nama Jenis Laporan')
                ->required()
                ->maxLength(150),

            Forms\Components\Select::make('handler_role')
                ->label('Role Penanggung Jawab')
                ->options(function () {
                    return Role::pluck('name', 'name')->toArray(); // Ambil role dari tabel roles
                })
                ->multiple() // Mendukung multiple roles
                ->required()
                ->helperText('Pilih role yang bertanggung jawab.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_jenis_laporan')
                    ->label('Nama Jenis Laporan')
                    ->searchable()
                    ->sortable(),

                    TextColumn::make('handler_role')
                    ->label('Role Penanggung Jawab')
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state)
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJenisLaporans::route('/'),
            'create' => Pages\CreateJenisLaporan::route('/create'),
            'edit' => Pages\EditJenisLaporan::route('/{record}/edit'),
        ];
    }
}
