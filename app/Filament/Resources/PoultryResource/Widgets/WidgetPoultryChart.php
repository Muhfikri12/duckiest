<?php

namespace App\Filament\Resources\PoultryResource\Widgets;

use App\Filament\Resources\PoultryResource\Pages\ListPoultries;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Poultry;
use App\Models\Room;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Illuminate\Support\Carbon;

class WidgetPoultryChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pertumbuhan Unggas';

    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListPoultries::class;
    }

    protected function getData(): array
    {
        $databebekQty = Trend::query(Poultry::query()
                        ->where('category', 'Bebek'))
            ->between(
                start: now()->subMonth(6),
                end: now(),
            )
            ->perMonth()
            ->sum('qty');

        $dataItikQty = Trend::query(Poultry::query()
                        ->where('category', 'Itik'))
            ->between(
                start: now()->subMonth(6),
                end: now(),
            )
            ->perMonth()
            ->sum('qty');
            
        $dataAyamQty = Trend::query(Poultry::query()
                        ->where('category', 'Ayam'))
            ->between(
                start: now()->subMonth(6),
                end: now(),
            )
            ->perMonth()
            ->sum('qty');
        $dataBurungQty = Trend::query(Poultry::query()
                        ->where('category', 'Burung'))
            ->between(
                start: now()->subMonth(6),
                end: now(),
            )
            ->perMonth()
            ->sum('qty');

        return [
            'datasets' => [
                [
                    'label' => 'Bebek',
                    'data' => $databebekQty->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#36A2EB', 
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)', 
                ],
                [
                    'label' => 'Itik',
                    'data' => $dataItikQty->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#FF6384', 
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                ],
                [
                    'label' => 'Ayam',
                    'data' => $dataAyamQty->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#9966FF', 
                    'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                ],
                [
                    'label' => 'Burung',
                    'data' => $dataBurungQty->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#FFCD56', 
                    'backgroundColor' => 'rgba(255, 205, 86, 0.2)',
                ],
            ],
            'labels' => $dataItikQty->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('F')),
        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }
}
