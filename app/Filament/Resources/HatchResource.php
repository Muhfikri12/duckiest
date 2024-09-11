<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HatchResource\Pages;
use App\Filament\Resources\HatchResource\RelationManagers;
use App\Models\Hatch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HatchResource extends Resource
{
    protected static ?string $model = Hatch::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('generation')
                    ->label('Nama')
                    ->required()
                    ->rule('required', 'Nama Harus Diisi')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->label('Tanggal Penetasan')
                    ->required(),
                Forms\Components\Select::make('type_eggs')
                    ->label('Jenis Telur')
                    ->options([
                        'Panen' => 'Panen',
                        'Tidak Panen' => 'Tidak Panen'
                    ])
                    ->required(),
                ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('generation')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label('Tanggal Penetasan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type_eggs')
                    ->label('Jenis Telur'),
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
            'index' => Pages\ListHatches::route('/'),
            'create' => Pages\CreateHatch::route('/create'),
            'view' => Pages\ViewHatch::route('/{record}'),
            'edit' => Pages\EditHatch::route('/{record}/edit'),
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
