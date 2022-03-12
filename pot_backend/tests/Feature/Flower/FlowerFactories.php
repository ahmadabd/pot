<?php

namespace Tests\Feature\Flower;

use App\Models\Role;

trait FlowerFactories {
    public function createRole(string $role): Role
    {
        return Role::factory()->create([
            'role' => $role,
        ]);
    }
}