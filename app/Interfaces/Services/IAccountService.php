<?php

namespace App\Interfaces\Services;

use App\Models\LoyaltyAccount;

interface IAccountService
{
    public function create(array $attributes): LoyaltyAccount;

    public function changeStatusAndNotify(string $type, string $id, bool $status) :void;

    public function getBalance(string $type, string $id) :float;
}
