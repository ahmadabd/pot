<?php

namespace Tests\Feature\Command\FertilizingToday;

use App\Models\Fertilizer;
use App\Models\Flower;
use App\Models\FlowerFertilizer;
use App\Models\Role;
use App\Models\User;

trait FertilizingTodayFactories
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
        $fertilizer = Fertilizer::factory()->create();

        foreach ($flowers as $flower) {
            $user->flowers()->attach($flower->id, ['role_id' => $this->createRole('owner')->id]);
            
            FlowerFertilizer::factory()->create([
                'flower_id' => $flower->id,
                'fertilizer_id' => $fertilizer->id,
                'period' => 2,
                'amount' => 1,
                'next_fertilizer_date' => now()
            ]);
        }

        return $flowers;
    }
}