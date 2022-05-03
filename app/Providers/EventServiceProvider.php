<?php

namespace App\Providers;

use App\Events\AccountActivated;
use App\Events\AccountDeactivated;
use App\Events\LoyaltyPointsReceived;
use App\Listeners\SendEmailAccountActivationNotification;
use App\Listeners\SendEmailAccountDeactivationNotification;
use App\Listeners\SendEmailLoyaltyPointsReceived;
use App\Listeners\SendSmsAccountActivationNotification;
use App\Listeners\SendSmsLoyaltyPointsReceived;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AccountActivated::class => [
            SendEmailAccountActivationNotification::class,
            SendSmsAccountActivationNotification::class
        ],
        AccountDeactivated::class => [
            SendEmailAccountDeactivationNotification::class,
            SendSmsAccountActivationNotification::class
        ],
        LoyaltyPointsReceived::class => [
            SendEmailLoyaltyPointsReceived::class,
            SendSmsLoyaltyPointsReceived::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
