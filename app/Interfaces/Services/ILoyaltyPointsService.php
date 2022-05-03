<?php

namespace App\Interfaces\Services;

use App\Models\LoyaltyAccount;
use App\Models\LoyaltyPointsTransaction;

interface ILoyaltyPointsService
{
    public function depositAndNotify(LoyaltyAccount $account, array $paymentAttributes): LoyaltyPointsTransaction;

    public function cancelTransaction(int $transactionId, $reason): void;

    public function withdraw(LoyaltyAccount $account, array $withdrawAttributes): LoyaltyPointsTransaction;
}
