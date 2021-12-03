<?php

namespace App\Listeners;

use App\Events\AccountActivated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendSmsAccountActivationNotification
{
    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        $account = $event->account;

        if ($account->phone_notification) {
            Log::info('Account: phone: ' . $account->phone . ' ' . ($account->active ? 'restored' : 'banned'));
        }
    }
}
