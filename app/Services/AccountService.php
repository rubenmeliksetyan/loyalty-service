<?php

namespace App\Services;

use App\Interfaces\Services\IAccountService;
use App\Models\LoyaltyAccount;

class AccountService implements IAccountService
{
    public function create(array $attributes): LoyaltyAccount
    {
        // TODO: assert required fields
        $account = new LoyaltyAccount($attributes);
        $account->save();
        return $account;
    }

    public function changeStatusAndNotify(string $type, string $id, bool $status): void
    {
        $account = $this->findByType($type, $id);
        $account->active = $status;
        $account->save();

        // TODO: refactor later on with notifications
        $message = $status ? 'Account restored' : 'Account banned';
        $account->notify($message);
    }

    public function getBalance(string $type, string $id): float
    {
        $loyaltyAccount = $this->findByType($type, $id);
        return $loyaltyAccount->notCanceledLoyaltyPointTransactions()->sum('points_amount');
    }

    public function findByType(string $type, string $id): LoyaltyAccount
    {
        return LoyaltyAccount::where($type, $id)->firstOrFail();
    }
}
