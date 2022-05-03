<?php

namespace App\Listeners;

use App\Events\LoyaltyPointsReceived;
use App\Services\AccountService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailLoyaltyPointsReceived
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
     * @param  LoyaltyPointsReceived  $event
     * @return void
     */
    public function handle(LoyaltyPointsReceived $event)
    {
        $account = $event->account;
        $transaction = $event->transaction;

        if ($account->email_notification) {
            Mail::to($account->email)->send(new \App\Mail\LoyaltyPointsReceived($transaction->points_amount, $this->accountService->getBalance('email', $account->email)));
        }
    }
}
