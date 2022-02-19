<?php

namespace App\Services\Token;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TokenManager implements Token
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