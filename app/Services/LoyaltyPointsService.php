<?php

namespace App\Services;

use App\Interfaces\Services\ILoyaltyPointsService;
use App\Models\LoyaltyAccount;
use App\Models\LoyaltyPointsTransaction;

class LoyaltyPointsService implements ILoyaltyPointsService
{
    public function depositAndNotify(LoyaltyAccount $account, array $paymentAttributes): LoyaltyPointsTransaction
    {
        // TODO: Implement depositAndNotify() method.
    }

    public function cancelTransaction(int $transactionId, $reason): void
    {
        // TODO: Implement cancelTransaction() method.
    }

    public function withdraw(LoyaltyAccount $account, array $withdrawAttributes): LoyaltyPointsTransaction
    {
        // TODO: Implement withdraw() method.
    }
}
