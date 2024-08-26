<?php

namespace App\Filament\Resources\PoultryResource\Pages;

use App\Filament\Resources\PoultryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPoultry extends EditRecord
{
    protected static string $resource = PoultryResource::class;
    protected static ?string $title = 'Merubah Unggas';

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
