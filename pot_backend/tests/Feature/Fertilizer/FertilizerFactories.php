<?php

namespace Tests\Feature\Fertilizer;

use App\Models\Fertilizer;
use App\Models\Flower;
use App\Models\FlowerFertilizer;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;

trait FertilizerFactories
{
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

    public function createFertilize()
    {
        return Fertilizer::factory()->create();
    }

    public function createFertilizerConfigs(int $flowerId, int $period)
    {
        $fertilizer = Fertilizer::factory()->create();
        
        return FlowerFertilizer::factory()->create([
            'flower_id' => $flowerId,
            'fertilizer_id' => $fertilizer->id,
            'period' => $period,
            'amount' => 1,
            'last_fertilizer_date' => Carbon::yesterday(),
            'next_fertilizer_date' => Carbon::yesterday()->addDays($period),
        ]);
    }
}