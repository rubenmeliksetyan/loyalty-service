<?php

namespace App\Services;

use App\Interfaces\Services\IUserService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{

    public function createUser(array $userAttributes): User
    {
        $user = new User();
        $user->email = $userAttributes['email'];
        $user->name = $userAttributes['name'];
        $user->password = Hash::make($userAttributes['password']);
        $user->save();
        return $user;
    }

    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    public function generateToken(User $user): string
    {
        return $user->createToken('apiToken')->plainTextToken;
    }

    public function login(string $email, string $password): User
    {
       $user = $this->findByEmail($email);
       if (Hash::check($password, $user->password)) {
           return $user;
       }
       return $user;
    }
}
