<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Jobs\SendOrderCreatedEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderInvoiceMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        SendOrderCreatedEmailJob::dispatch($event->order);
    }
}
