<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class NotificationObserver
{

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
}
