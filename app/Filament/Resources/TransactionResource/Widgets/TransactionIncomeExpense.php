<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class TransactionIncomeExpense extends ChartWidget
{
    protected static ?string $heading = 'Laporan Keuangan';

    protected function getData(): array
    {
        $income = Trend::query(Transaction::query()
            ->whereHas('category', function($query) {
                $query->where('type', 'Pemasukan');
            }))
            ->between(
                start: now()->subMonth(6),
                end: now()
            )
            ->perMonth()
            ->sum('total');

        $expense = Trend::query(Transaction::query()
            ->whereHas('category', function($query) {
                $query->where('type', 'Pengeluaran');
            }))
            ->between(
                start: now()->subMonth(6),
                end: now()
            )
            ->perMonth()
            ->sum('total');

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => $income->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#36A2EB', 
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)', 
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $expense->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#FF6384', 
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                ],
            ],
            'labels' => $income->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('F')),
        ];
        
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
