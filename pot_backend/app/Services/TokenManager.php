<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TokenManager 
{
    public function checkToken(string $password, User $user): bool
    {
        return Hash::check($password, $user->password);
    }

    public function createToken(string $password): string
    {
        return Hash::make($password);
    }

    public function destroyToken(User $user): void
    {
        $user->tokens()->delete();
    }
}