<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HatchTreatmentResource\Pages;
use App\Filament\Resources\HatchTreatmentResource\RelationManagers;
use App\Models\HatchTreatment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HatchTreatmentResource extends Resource
{
    protected static ?string $model = HatchTreatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationGroup = 'Penetasan';
    protected static ?string $navigationLabel = 'Perawatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('blocks_id')
                    ->label('Kamar')
                    ->relationship('Block', 'name')
                    ->required(),
                Forms\Components\Select::make('fase')
                    ->options([
                        'Minggu 1' => 'Minggu 1',
                        'Minggu 2' => 'Minggu 2',
                        'Minggu 3' => 'Minggu 3',
                        'Minggu 4' => 'Minggu 4'
                    ])
                    ->required(),
                Forms\Components\TextInput::make('temperature')
                    ->label('Suhu')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('humadity')
                    ->label('Kelembapan')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('died_qty')
                    ->label('Total Kematian')
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->label('Keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('blocks_id')
                    ->label('Kamar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fase'),
                Tables\Columns\TextColumn::make('temperature')
                    ->label('Suhu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('humadity')
                    ->label('Kelembapan')
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
            'index' => Pages\ListHatchTreatments::route('/'),
            'create' => Pages\CreateHatchTreatment::route('/create'),
            'view' => Pages\ViewHatchTreatment::route('/{record}'),
            'edit' => Pages\EditHatchTreatment::route('/{record}/edit'),
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
