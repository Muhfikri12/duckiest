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
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Total Kelahiran Itik', number_format($this->getPageTableQuery()->where('category', 'itik')->count(), 0, ',', ',') . ' Kali')
                ->chart([3, 2, 5, 2, 7, 4, 2]),
            Stat::make('Total Kematian', number_format(
                    $this->getTotalDiedQty(), 0, ',', ',') . ' Ekor'
                )->chart([1, 4, 7, 4, 8, 7, 9]),
        ];
    }

    protected function getTotalDiedQty(): int
    {
        // Ambil query dari halaman tabel yang difilter
        $query = $this->getPageTableQuery();

        // Join dengan tabel yang diperlukan
        $query->join('rooms', 'rooms.poultry_id', '=', 'poultries.id');

        // Hitung total died_qty
        return $query->sum('rooms.died_qty');
    }
}
