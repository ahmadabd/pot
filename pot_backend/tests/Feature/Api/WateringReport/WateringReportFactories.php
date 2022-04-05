<?php

namespace Tests\Feature\Api\WateringReport;

use App\Models\Flower;
use App\Models\Role;
use App\Models\User;
use App\Models\Watering;
use App\Models\WateringReport;

trait WateringReportFactories
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

    public function createWatering(int $flowreId, int $period)
    {
        return Watering::factory()->create([
            'flower_id' => $flowreId,
            'period' => $period,
        ]);
    }

    public function createWateringReport(int $flowerId, int $userId)
    {
        return WateringReport::factory()->create([
            'flower_id' => $flowerId,
            'watering_id' => $this->createWatering($flowerId, 4)->id,
            'user_id' => $userId,
        ]);
    }
}