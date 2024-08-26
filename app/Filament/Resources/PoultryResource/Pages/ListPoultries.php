<?php

namespace App\Filament\Resources\PoultryResource\Pages;

use App\Filament\Resources\PoultryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPoultries extends ListRecords
{
    protected static string $resource = PoultryResource::class;
    protected static ?string $title = 'Grafik Tabel Unggas';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
