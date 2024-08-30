<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Category;
use App\Models\Poultry;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use NumberFormatter;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $status = Category::find($state)?->type;
                        $set('is_poultry_disabled', $status === 'Pengeluaran');
                        $set('is_poultry_required', $status === 'Pemasukan');
                        $set('is_max_qty_active', $status === 'Pemasukan');
                    }),

                Forms\Components\Select::make('poultry_id')
                    ->label('Unggas')
                    ->relationship('poultry', 'generation', function ($query) {
                        $query->where('status', '!=', 'Terjual');
                    })
                    ->required(fn (callable $get) => $get('is_poultry_required'))
                    ->disabled(fn (callable $get) => $get('is_poultry_disabled'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                       
                        $poultry = \App\Models\Poultry::find($state);
                        $initialQty = $poultry?->qty ?? 0;

                        $previousTransactionQty = \App\Models\Transaction::where('poultry_id', $state)
                            ->sum('qty'); 
                
                        $maxQty = $initialQty - $previousTransactionQty;
         
                        $set('max_qty', $maxQty);
                    }),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_transaction')
                    ->required(),
                Forms\Components\TextInput::make('qty')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $set('total', $get('price') * $state);
                    })
                    ->maxValue(fn (callable $get) => $get('is_max_qty_active') ? $get('max_qty') : null)
                    ->rule(function (callable $get) {
                        $maxQty = $get('is_max_qty_active') ? $get('max_qty') : null;
                        return $maxQty ? "max:$maxQty" : null;
                    })
                    ->hint(fn (callable $get) => $get('is_max_qty_active') ? "Max available quantity: " . $get('max_qty') : ""),                
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $set('total', $state * $get('qty'));
                    }),
                
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->disabled() 
                    ->dehydrated(true)
                    ->reactive(),
                     
                Forms\Components\FileUpload::make('image')
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('category.image')
                    ->label('Icon'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Transaksi')
                    ->description(fn (Transaction $record): string => $record->poultry->generation ?? $record->name)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.type')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pengeluaran' => 'warning',
                        'Pemasukan' => 'success',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Struck'),
                Tables\Columns\TextColumn::make('date_transaction')
                    ->label('Tanggal')
                    ->date()
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
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
