<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class NotificationObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $authUser = Auth::user();

        if (!$authUser) {
            return; // Don't send notification if no user is authenticated
        }

        Notification::make()
            ->title('Order Placed')
            ->body('Your order has been placed successfully')
            ->sendToDatabase($authUser);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
