<?php

namespace App\Filament\Resources\PoultryResource\Pages;

use App\Filament\Resources\PoultryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePoultry extends CreateRecord
{
    protected static string $resource = PoultryResource::class;
    protected static ?string $title = 'Membuat Unggas';
}
