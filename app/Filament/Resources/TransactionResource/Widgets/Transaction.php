<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Filament\Resources\TransactionResource\Pages\ListTransactions;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Transaction extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListTransactions::class;
    }

    protected function getStats(): array
    {
        return [
            
            Stat::make('Total Pemasukan','Rp. ' . number_format($this->getPageTableQuery()
                ->join('categories', 'transactions.category_id', '=', 'categories.id')
                ->where('categories.type', 'Pemasukan')
                ->sum('transactions.total'), 0, ',', '.'))
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Total Pengeluaran','Rp. ' . number_format($this->getPageTableQuery()
                ->join('categories', 'transactions.category_id', '=', 'categories.id')
                ->where('categories.type', 'Pengeluaran')
                ->sum('transactions.total'), 0, ',', '.'))
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}
