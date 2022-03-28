<?php

namespace Tests\Feature\Command\WateringToday;

use App\Models\Flower;
use App\Models\Role;
use App\Models\User;
use App\Models\Watering;

trait WateringTodayFactories
{
    public function createRole(string $role): Role
    {
        return Role::factory()->create([
            'role' => $role,
        ]);
    }

    public function createFlowerUser(User $user, $count = 1)
    {
        $flowers = Flower::factory($count)->create();

        foreach ($flowers as $flower) {
            $user->flowers()->attach($flower->id, ['role_id' => $this->createRole('owner')->id]);
            
            Watering::factory()->create([
                'flower_id' => $flower->id,
                'period' => 2,
                'next_watering_date' => now()
            ]);
        }

        return $flowers;
    }
}