<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductPurchasedNotification extends Notification
{
    use Queueable;

    protected $purchaseId;
    protected $productName;

    public function __construct($purchaseId, $productName)
    {
        $this->purchaseId = $purchaseId;
        $this->productName = $productName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pesanan Baru',
            'message' => 'Ada pesanan baru untuk produk: ' . $this->productName,
            'purchase_id' => $this->purchaseId,
        ];
    }
}
