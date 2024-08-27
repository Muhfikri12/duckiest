<?php

namespace App\Filament\Resources\PoultryResource\Widgets;

use App\Models\Poultry;
use App\Models\Room;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class widgetYearlyPoultryChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Tahunan Unggas';

    protected function getData(): array
    {
        $dataQty = Trend::model(Poultry::class)
            ->between(
                start: now()->startOfYear()->subYears(6),
                end: now()->endOfYear(),
            )
            ->perYear()
            ->sum('qty');

        $dataDiedQty = Trend::model(Room::class)
            ->between(
                start: now()->startOfYear()->subYears(6),
                end: now()->endOfYear(),
            )
            ->perYear()
            ->sum('died_qty');

        return [
            'datasets' => [
                [
                    'label' => 'Grafik Total Unggas',
                    'data' => $dataQty->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#36A2EB', 
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)', 
                ],
                [
                    'label' => 'Grafik Unggas Mati',
                    'data' => $dataDiedQty->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#FF6384', 
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                ],
            ],
            'labels' => $dataQty->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
