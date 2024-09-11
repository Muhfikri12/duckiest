<?php

namespace App\Filament\Resources\HatchTreatmentResource\Pages;

use App\Filament\Resources\HatchTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHatchTreatment extends EditRecord
{
    protected static string $resource = HatchTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
