<?php

namespace App\Filament\Resources\HatchTreatmentResource\Pages;

use App\Filament\Resources\HatchTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHatchTreatments extends ListRecords
{
    protected static string $resource = HatchTreatmentResource::class;
    protected static ?string $title = 'Perawatan Penetasan Telur';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
