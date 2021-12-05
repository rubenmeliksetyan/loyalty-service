<?php

namespace App\Interfaces\Services;

use App\Models\User;

interface IUserService
{
    public function createUser(array $userAttributes): User;

    public function findByEmail(string $email): User;
}
