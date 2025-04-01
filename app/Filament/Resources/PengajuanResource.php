<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pengaduan;
use Filament\Tables\Table;
use App\Models\JenisLaporan;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PengajuanResource\Pages;
use Illuminate\Support\Facades\Log; // Untuk debugging
use App\Filament\Resources\PengajuanResource\Pages\EditPengajuan;
use App\Filament\Resources\PengajuanResource\Pages\ListPengajuans;
use App\Filament\Resources\PengajuanResource\Pages\CreatePengajuan;

class PengajuanResource extends Resource
{
    protected static ?string $model = Pengaduan::class;
    protected static ?int $navigationSort = 2; // Sesuaikan urutan
    protected static ?string $navigationTitle = 'Pengajuan Pengaduan';
    protected static ?string $navigationGroup = 'Pengajuan Pengaduan';
    protected static ?string $label = 'Pengajuan Pengaduan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('judul')
                    ->label('Judul')
                    ->required()
                    ->maxLength(150),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->required(),

                Select::make('id_jenis_laporan')
                    ->label('Jenis Laporan')
                    ->options(function () {
                        return JenisLaporan::pluck('nama_jenis_laporan', 'id');
                    })
                    ->required(),

                    FileUpload::make('foto')
                    ->multiple()
     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn($record) => $record?->deskripsi),

                TextColumn::make('jenisLaporan.nama_jenis_laporan')
                    ->label('Jenis Laporan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Tanggal Selesai')
                    ->dateTime('d M Y H:i') // Format tanggal
                    ->sortable()
                    ->visible(fn($record) => $record && in_array($record->status, ['selesai'])),

                ImageColumn::make('foto')
                    ->label('Foto Bukti')
                    ->disk('public')
                    ->visibility('public')
                    ->url(function (Model $record) {
                        if ($record && $record->foto) {
                            return Storage::url('pengaduan-foto/' . $record->foto);
                        }
                        return null;
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'pelaporan_kelas' => 'Pelaporan Kelas',
                        'pelaporan_lab' => 'Pelaporan Lab',
                        'proses' => 'Proses',
                        'selesai' => 'Selesai',
                        'tidak_selesai' => 'Tidak Selesai',
                        'ditolak' => 'Ditolak',
                        'dalam_proses' => 'Dalam Proses',
                    ]),
            ])
            ->actions([
                Action::make('ajukan')
                    ->label('Ajukan')
                    ->action(function ($record) {
                        try {
                            if (!$record) {
                                throw new \Exception("Record tidak ditemukan.");
                            }

                            $record->submit();

                            Notification::make()
                                ->title('Laporan Diajukan!')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal Mengajukan!')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(function ($record) {
                        return $record && $record->status === Pengaduan::STATUS_PENDING;
                    }),
            ]);
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('status', [
                Pengaduan::STATUS_PENDING,
                Pengaduan::STATUS_PELAPORAN_KELAS,
                Pengaduan::STATUS_PELAPORAN_LAB,
                Pengaduan::STATUS_PROSES,
                Pengaduan::STATUS_SELESAI,
                Pengaduan::STATUS_TIDAK_SELESAI,
                Pengaduan::STATUS_DITOLAK,
                Pengaduan::STATUS_DALAM_PROSES
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengajuans::route('/'),
            'create' => Pages\CreatePengajuan::route('/create'),
            'edit' => Pages\EditPengajuan::route('/{record}/edit'),
        ];
    }
}
