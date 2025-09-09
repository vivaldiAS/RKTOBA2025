<?php

namespace App\Providers;

use App\Events\OrderStatusUpdated;
use App\Listeners\SendOrderStatusUpdateNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderStatusUpdated::class => [
            SendOrderStatusUpdateNotification::class,
        ],
    ];
}
