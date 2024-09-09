<?php

namespace App\Providers;

use App\Events\RegistrationOTPSendEvent;
use App\Events\EmailOTPEvent;
use App\Events\OrderCreateEvent;
use App\Events\OrderStatusEvent;
use App\Listeners\RegistrationOTPSendListener;
use App\Listeners\EmailOTPListener;
use App\Listeners\OrderCreateListener;
use App\Listeners\OrderStatusListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        OrderCreateEvent::class => [
            OrderCreateListener::class,
        ],

        OrderStatusEvent::class => [
            OrderStatusListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
