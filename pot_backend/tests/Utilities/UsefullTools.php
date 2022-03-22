<?php

namespace Tests\Utilities;

use App\Models\User;

trait UsefullTools 
{
    public function AuthenticatedUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        return $user;
    }
}