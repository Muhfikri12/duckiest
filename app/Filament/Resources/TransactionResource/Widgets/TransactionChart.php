<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class TransactionChart extends ChartWidget
{
    protected static ?string $heading = 'Laporan Penjualan';
    use InteractsWithPageTable;

    protected function getData(): array
    {
        
        $duck = Trend::query(Transaction::query()
            ->whereHas('poultry', function($query) {
                $query->where('category', 'Bebek');
            }))
            ->between(
                start: now()->subMonth(6),
                end: now()
            )
            ->perMonth()
            ->sum('total');
        $chicken = Trend::query(Transaction::query()
            ->whereHas('poultry', function($query) {
                $query->where('category', 'Ayam');
            }))
            ->between(
                start: now()->subMonth(6),
                end: now()
            )
            ->perMonth()
            ->sum('total');
        $duckling = Trend::query(Transaction::query()
            ->whereHas('poultry', function($query) {
                $query->where('category', 'Itik');
            }))
            ->between(
                start: now()->subMonth(6),
                end: now()
            )
            ->perMonth()
            ->sum('total');
        $bird = Trend::query(Transaction::query()
            ->whereHas('poultry', function($query) {
                $query->where('category', 'Burung');
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
                    'label' => 'Bebek',
                    'data' => $duck->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#36A2EB', 
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)', 
                ],
                [
                    'label' => 'Ayam',
                    'data' => $chicken->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#9966FF', 
                    'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                ],
                [
                    'label' => 'Itik',
                    'data' => $duckling->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#FF6384', 
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                ],
                [
                    'label' => 'Burung',
                    'data' => $bird->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#FF6384', 
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                ],
            ],
            'labels' => $duck->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('F')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
