<?php

namespace App\Filament\Resources\TreatmentResource\Widgets;

use App\Filament\Resources\TreatmentResource\Pages\ListTreatments;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TreatmentWidget extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListTreatments::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Pakan', number_format($this->getPageTableQuery()->sum('feed_qty'), 0, ',', '.') . ' Kg')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            // Stat::make('Total Kematian', number_format(
            //         $this->getTotalDiedQty(), 0, ',', ',') . ' Ekor'
            //     )->chart([1, 4, 7, 4, 8, 7, 9]),
            // Stat::make('Total Telur', number_format(
            //         $this->getTotalEggQty(), 0, ',', ',') . ' Butir'
            //     )->chart([1, 4, 7, 4, 8, 7, 9]),
        ];
    }

    protected function getTotalDiedQty(): int
    {
        // Ambil query dari halaman tabel yang difilter
        $query = $this->getPageTableQuery()
                ->join('rooms', 'rooms.poultry_id', '=', 'poultries.id');     
        return $query->sum('rooms.died_qty');
    }

    protected function getTotalEggQty(): int
    {
       
        $query = $this->getPageTableQuery()
                ->join('rooms', 'rooms.poultry_id', '=', 'poultries.id');
                
        return $query->sum('rooms.egg_qty');
    }
}
