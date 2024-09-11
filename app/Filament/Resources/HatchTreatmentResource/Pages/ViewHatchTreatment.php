<?php

namespace App\Filament\Resources\HatchTreatmentResource\Pages;

use App\Filament\Resources\HatchTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHatchTreatment extends ViewRecord
{
    protected static string $resource = HatchTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
