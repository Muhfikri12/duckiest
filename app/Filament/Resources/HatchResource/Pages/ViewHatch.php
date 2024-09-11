<?php

namespace App\Filament\Resources\HatchResource\Pages;

use App\Filament\Resources\HatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHatch extends ViewRecord
{
    protected static string $resource = HatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
