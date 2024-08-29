<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use App\Notifications\Transaction;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

}
