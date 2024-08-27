<?php

namespace App\Filament\Resources\PoultryResource\Widgets;

use App\Filament\Resources\PoultryResource\Pages\ListPoultries;
use App\Models\Poultry;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PoultryChart extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListPoultries::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Unggas', number_format($this->getPageTableQuery()->sum('qty'), 0, ',', '.') . ' Ekor')
            // Stat::make('Confirmed Orders', $this->getPageTableQuery()->where('status', 'confirmed')->count()),
            // Stat::make('Cancelled Orders', $this->getPageTableQuery()->where('status', 'cancelled')->count()),
        ];
    }
}
