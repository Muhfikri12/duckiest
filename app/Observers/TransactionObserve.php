<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Models\User;
use Filament\Notifications\Notification;

class TransactionObserve
{
    /**
     * Handle the Transaction "created" event.
     */
    // public function toDatabase(Transaction $notifiable): array
    //     {
    //         return Notification::make()
    //             ->title('Saved successfully')
    //             ->getDatabaseMessage();
    //     }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
