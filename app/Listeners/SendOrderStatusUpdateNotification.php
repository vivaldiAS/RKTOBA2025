<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Models\User;
use App\Notifications\OrderStatusUpdateNotification;
use Illuminate\Support\Facades\Notification;

class SendOrderStatusUpdateNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderStatusUpdated  $event
     * @return void
     */
    public function handle(OrderStatusUpdated $event)
    {
        $purchase = $event->purchase;
        $statusMessage = $event->statusMessage;

        // Cari pembeli berdasarkan ID
        $user = User::find($purchase->user_id);
        if ($user) {
            // Kirimkan notifikasi ke pembeli
            $user->notify(new OrderStatusUpdateNotification($purchase->purchase_id, $statusMessage));
        }
    }
}
