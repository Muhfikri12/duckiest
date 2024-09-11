<?php

namespace App\Filament\Resources\HatchResource\Pages;

use App\Filament\Resources\HatchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHatch extends EditRecord
{
    protected static string $resource = HatchResource::class;

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
