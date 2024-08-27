<?php

namespace App\Filament\Resources\PoultryResource\Pages;

use App\Filament\Resources\PoultryResource;
use App\Filament\Resources\PoultryResource\Widgets\PoultryChart;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPoultry extends ViewRecord
{
    protected static string $resource = PoultryResource::class;
    protected static ?string $title = 'Preview';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

}
