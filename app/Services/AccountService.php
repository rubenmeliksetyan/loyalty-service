<?php

namespace App\Services;

use App\Events\AccountActivated;
use App\Events\AccountDeactivated;
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
        event($status ? new AccountActivated($account) : new AccountDeactivated($account));
    }

    public function getBalance(string $type, string $id): float
    {
        $loyaltyAccount = $this->findByType($type, $id);
        return $loyaltyAccount->notCanceledLoyaltyPointTransactions()->sum('points_amount');
    }

    public function findByType(string $type, string $id): LoyaltyAccount
    {
        return LoyaltyAccount::where($type, $id)->where('active', 1)->firstOrFail();
    }
}
