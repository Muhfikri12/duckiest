<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Filament\Resources\TransactionResource\Widgets\Transaction;
use App\Filament\Resources\TransactionResource\Widgets\TransactionChart;
use App\Filament\Resources\TransactionResource\Widgets\TransactionIncomeExpense;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    use ExposesTableToWidgets;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Transaction::class,
            TransactionChart::class,
            TransactionIncomeExpense::class
        ];
    }
}
