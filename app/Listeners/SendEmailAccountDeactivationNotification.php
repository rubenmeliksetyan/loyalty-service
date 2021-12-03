<?php

namespace App\Listeners;

use App\Events\AccountDeactivated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountDeactivated as AccountDeactivatedEmail;

class SendEmailAccountDeactivationNotification
{
    /**
     * Handle the event.
     *
     * @param  AccountDeactivated  $event
     * @return void
     */
    public function handle(AccountDeactivated $event)
    {
        $account = $event->account;

        if ($account->email_notification) {
            Mail::to($account->email)->send(new AccountDeactivatedEmail());
        }
    }
}
