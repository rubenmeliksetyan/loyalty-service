<?php

namespace App\Listeners;

use App\Events\AccountActivated;
use App\Services\AccountService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActivated as AccountActivatedEmail;

class SendEmailAccountActivationNotification
{
    private AccountService $accountService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Handle the event.
     *
     * @param  AccountActivated  $event
     * @return void
     */
    public function handle(AccountActivated $event)
    {
        $account = $event->account;

        if ($account->email_notification) {
            Mail::to($account->email)->send(new AccountActivatedEmail($this->accountService->getBalance('email',$account->email)));
        }
    }
}
