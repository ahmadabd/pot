<?php

namespace Tests\Feature\Flower;

use App\Models\Flower;
use App\Models\Role;
use App\Models\User;

trait FlowerFactories {
    public function createRole(string $role): Role
    {
        return Role::factory()->create([
            'role' => $role,
        ]);
    }

    public function createFlowerUser(User $user)
    {
        $flower = Flower::factory()->create();

        $user->flowers()->attach($flower->id, ['role_id' => $this->createRole('owner')->id]);

        return $flower;
    }
}