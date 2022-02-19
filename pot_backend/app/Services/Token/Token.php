<?php

namespace App\Services\Token;

use App\Models\User;

interface Token 
{
    public function checkToken(string $password, User $user): bool;

    public function createToken(string $password): string;

    public function destroyToken(User $user): void;
}