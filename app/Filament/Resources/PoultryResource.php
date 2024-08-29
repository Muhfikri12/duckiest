<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoultryResource\Pages;
use App\Filament\Resources\PoultryResource\RelationManagers;
use App\Models\Poultry;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\Treatment;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class PoultryResource extends Resource
{
    protected static ?string $model = Poultry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Unggas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('generation')
                    ->label('Generasi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('qty')
                    ->label('Jumlah')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('vaccine')
                    ->label('Vaksin')
                    ->options([
                        'Belum Vaksin' => 'Belum Vaksin',
                        'Vaksin 1' => 'Vaksin 1',
                        'Vaksin 2' => 'Vaksin 2',
                        'Vaksin 3' => 'Vaksin 3'
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->label('Tanggal Lahir')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'Tersedia' => 'Tersedia',
                        'Terjual' => 'Terjual'
                    ])
                    ->required(),
                Forms\Components\Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'Bebek' => 'Bebek',
                        'Itik' => 'Itik',
                        'Ayam' => 'Ayam',
                        'Angsa' => 'Angsa',
                        'Entog' => 'Entog',
                        'Burung' => 'Burung'
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('icon')
                    ->label('Icon')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon')
                    ->label('Icon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->description(fn (Poultry $record): string => $record->generation)
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('qty')
                    ->description(function ($record) {
                        $diedQty = Room::where('poultry_id', $record->id)
                            ->sum('died_qty');
                        return 'Kematian: ' . $diedQty;
                    })
                    ->label('Jumlah')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.qty')
                    ->label('Terjual')
                    ->getStateUsing(function ($record) {
                        return Transaction::where('poultry_id', $record->id)
                            ->sum('qty');
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('room.treatment.egg_qty')
                    ->label('Total Telur')
                    ->getStateUsing(function ($record) {
                        return Room::where('poultry_id', $record->id)
                            ->sum('egg_qty');
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label('Tanggal Lahir')
                    ->dateTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('vaccine')
                    ->label('Vaksin')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Belum Vaksin' => 'danger',
                        'Vaksin 1' => 'warning',
                        'Vaksin 2' => 'info',
                        'Vaksin 3' => 'success',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Tersedia' => 'success',
                        'Terjual' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('date_of_birth')
                        ->form([
                            Forms\Components\DatePicker::make('Tanggal Awal')
                                ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                            Forms\Components\DatePicker::make('Tanggal Akhir')
                                ->placeholder(fn ($state): string => now()->format('M d, Y')),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['Tanggal Awal'] ?? null,
                                    fn (Builder $query, $date): Builder => $query->whereDate('date_of_birth', '>=', $date),
                                )
                                ->when(
                                    $data['Tanggal Akhir'] ?? null,
                                    fn (Builder $query, $date): Builder => $query->whereDate('date_of_birth', '<=', $date),
                                );
                        })
                        ->indicateUsing(function (array $data): array {
                            $indicators = [];
                            if ($data['Tanggal Awal'] ?? null) {
                                $indicators['Tanggal Awal'] = 'Awal ' . Carbon::parse($data['Tanggal Awal'])->toFormattedDateString();
                            }
                            if ($data['Tanggal Akhir'] ?? null) {
                                $indicators['Tanggal Akhir'] = 'Akhir ' . Carbon::parse($data['Tanggal Akhir'])->toFormattedDateString();
                            }

                            return $indicators;
                        }),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([ 
                        'Bebek' => 'Bebek',
                        'Itik' => 'Itik',
                        'Ayam' => 'Ayam',
                        'Angsa' => 'Angsa',
                        'Entog' => 'Entog',
                        'Burung' => 'Burung'
                        
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Tersedia' => 'Tersedia',
                        'Terjual' => 'Terjual',
                        
                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPoultries::route('/'),
            'create' => Pages\CreatePoultry::route('/create'),
            'view' => Pages\ViewPoultry::route('/{record}'),
            'edit' => Pages\EditPoultry::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->orderByRaw("CASE WHEN status = 'Terjual' THEN 1 ELSE 0 END ASC")
            ->orderBy('created_at', 'desc'); // Optional: Secondary ordering by created_at
    }
}
