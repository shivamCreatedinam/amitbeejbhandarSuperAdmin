<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
use App\Mail\OrderCreateMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class OrderCreateListener
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
    public function handle(OrderCreateEvent $event): void
    {
        Mail::to($event->order->email)->send(new OrderCreateMail($event->order, $event->from_mail));
    }
}
