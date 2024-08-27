<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $disabled = fn ($livewire) => $livewire->record && $livewire->record->poultry->status === 'Terjual';

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Ruangan')
                    ->required()
                    ->maxLength(255)
                    ->disabled($disabled),
                Forms\Components\Select::make('type')
                    ->label('Jenis')
                    ->options([
                        'Bebek' => 'Bebek',
                        'Itik' => 'Itik',
                        'Ayam' => 'Ayam',
                        'Angsa' => 'Angsa',
                        'Entog' => 'Entog',
                        'Burung' => 'Burung'
                    ])
                    ->required()
                    ->reactive()
                    ->disabled($disabled),
                Forms\Components\TextInput::make('qty_duck')
                    ->label('Jumlah Unggas')
                    ->required()
                    ->numeric()
                    ->disabled($disabled),
                Forms\Components\TextInput::make('egg_qty')
                    ->label('Total Telur')
                    ->numeric()
                    ->disabled(function ($get, $livewire) use ($disabled) {
                        return $disabled($livewire) || $get('type') === 'Itik' || $livewire instanceof \Filament\Resources\Pages\CreateRecord;
                    }),
                Forms\Components\TextInput::make('died_qty')
                    ->label('Jumlah Kematian')
                    ->numeric()
                    ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->disabled($disabled),
                Forms\Components\Select::make('poultry_id')
                    ->label('Angkatan')
                    ->relationship('poultry', 'generation', function ($query, $get) {
                        $query->where('status', '!=', 'Terjual')
                            ->where('category', $get('type'));
                    })
                    ->disabled($disabled)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('poultry.icon')
                    ->label('Icon'),
                Tables\Columns\TextColumn::make('poultry.category')
                    ->description(fn (Room $record): string => $record->poultry->generation)
                    ->label('Generasi')
                    ->searchable(query: function ($query, $search) {
                        // Search in the related poultry's category name
                        $query->orWhereHas('poultry', function ($query) use ($search) {
                            $query->where('category', 'like', "%{$search}%")
                                  ->orWhere('generation', 'like', "%{$search}%");
                        });
                    }),
                Tables\Columns\TextColumn::make('name')
                    ->badge()
                    ->color('info')
                    ->label('Kandang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty_duck')
                    ->label('Jumlah Unggas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('egg_qty')
                    ->label('Total Telur')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('died_qty')
                    ->label('Total Kematian')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'view' => Pages\ViewRoom::route('/{record}'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
