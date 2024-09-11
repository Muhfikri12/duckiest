<?php

namespace App\Filament\Resources\HatchResource\Pages;

use App\Filament\Resources\HatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHatches extends ListRecords
{
    protected static string $resource = HatchResource::class;
    protected static ?string $title = 'Penetasan Telur';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
