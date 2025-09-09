<?php

namespace App\Events;

use App\Models\ProductPurchase;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated
{
    use Dispatchable, SerializesModels;

    public $purchase;
    public $statusMessage;

    /**
     * Create a new event instance.
     *
     * @param ProductPurchase $purchase
     * @param string $statusMessage
     * @return void
     */
    public function __construct(ProductPurchase $purchase, string $statusMessage)
    {
        $this->purchase = $purchase;
        $this->statusMessage = $statusMessage;
    }
}
