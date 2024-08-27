<?php

namespace App\Filament\Resources\PoultryResource\Pages;

use App\Filament\Resources\PoultryResource;
use App\Filament\Resources\PoultryResource\Widgets\PoultryChart;
use App\Filament\Resources\PoultryResource\Widgets\WidgetPoultryChart;
use App\Filament\Resources\PoultryResource\Widgets\widgetYearlyPoultryChart;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListPoultries extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = PoultryResource::class;
    protected static ?string $title = 'Grafik Tabel Unggas';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PoultryChart::class,
            WidgetPoultryChart::class,
            widgetYearlyPoultryChart::class,
        ];
    }
}
