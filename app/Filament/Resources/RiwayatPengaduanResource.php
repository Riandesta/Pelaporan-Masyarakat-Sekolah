<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pengaduan;
use Filament\Tables\Table;
use App\Models\RiwayatPengaduan;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RiwayatPengaduanResource\Pages;
use App\Filament\Resources\RiwayatPengaduanResource\RelationManagers;

class RiwayatPengaduanResource extends Resource
{
    protected static ?string $model = Pengaduan::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock'; // Ikon riwayat
    protected static ?string $navigationLabel = 'Riwayat Pengaduan';
    protected static ?string $label = 'Riwayat Pengaduan';
    protected static ?string $navigationGroup = 'Pengajuan Pengaduan';

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
                    ->limit(50)
                    ->tooltip(fn ($record) => $record?->deskripsi),

                TextColumn::make('jenisLaporan.nama_jenis_laporan')
                    ->label('Jenis Laporan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                ImageColumn::make('foto')
                    ->label('Foto Bukti')
                    ->disk('public')
                    ->visibility('public')
                    ->url(function (Pengaduan $record) {
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'pelaporan_kelas' => 'Pelaporan Kelas',
                        'pelaporan_lab' => 'Pelaporan Lab',
                        'proses' => 'Proses',
                        'selesai' => 'Selesai',
                        'tidak_selesai' => 'Tidak Selesai',
                        'ditolak' => 'Ditolak',
                    ]),

                // Filter Per Hari, Minggu, dan Bulan
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators[] = 'Dari: ' . $data['from'];
                        }
                        if ($data['until'] ?? null) {
                            $indicators[] = 'Sampai: ' . $data['until'];
                        }
                        return $indicators;
                    }),
            ])
            ->actions([
                // Tombol Print untuk satu data
                Tables\Actions\Action::make('print')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->url(fn (Pengaduan $record): string => route('print.pengaduan', ['id' => $record->id]))
                    ->openUrlInNewTab(),
            ])
            ->headerActions([
                // Tombol Print All untuk semua data
                Tables\Actions\Action::make('print_all')
                    ->label('Print All')
                    ->icon('heroicon-o-printer')
                    ->action(function (Tables\Actions\Action $action) {
                        return redirect()->route('print.all.pengaduan');
                    }),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRiwayatPengaduans::route('/'),
        ];
    }
}
