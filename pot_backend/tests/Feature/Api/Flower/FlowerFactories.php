<?php

namespace Tests\Feature\Api\Flower;

use App\Models\Fertilizer;
use App\Models\Flower;
use App\Models\FlowerFertilizer;
use App\Models\Role;
use App\Models\User;
use App\Models\Watering;
use Carbon\Carbon;

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

    public function createWatering(int $flowerId, int $period)
    {
        return Watering::factory()->create([
            'flower_id' => $flowerId,
            'period' => $period,
            'last_watering_date' => Carbon::yesterday(),
            'next_watering_date' => Carbon::yesterday()->addDays($period),
        ]);
    }

    public function createFertilizer(int $flowerId, int $period)
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