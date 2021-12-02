<?php

namespace App\Services;

use App\Interfaces\Services\IAccountService;
use App\Models\LoyaltyAccount;

class AccountService implements IAccountService
{
    public function create(array $attributes): LoyaltyAccount
    {
        // TODO: Implement create() method.
    }

    public function changeStatusAndNotify(string $type, string $id, bool $status): void
    {
        // TODO: Implement changeStatusAndNotify() method.
    }

    public function getBalance(string $type, string $id): float
    {
        // TODO: Implement getBalance() method.
    }
}
