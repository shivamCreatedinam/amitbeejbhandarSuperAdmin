<?php

namespace App\Listeners;

use App\Events\OrderStatusevent;
use App\Mail\OrderStatusMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class OrderStatusListener
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
    public function handle(OrderStatusevent $event): void
    {
        Mail::to($event->order->email)->send(new OrderStatusMail($event->order, $event->from_mail));
    }
}
