<?php

namespace Tests\Feature\Api\FertilizingReport;

use App\Models\Fertilizer;
use App\Models\Flower;
use App\Models\FlowerFertilizer;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;

trait FertilizingReportFactories
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

    public function createFertilizer()
    {
        return Fertilizer::factory()->create();
    }

    public function createFlowerFertilizerConfigs(int $flowerId, int $period, $nextFertilize = null)
    {
        $fertilizer = Fertilizer::factory()->create();
        
        return FlowerFertilizer::factory()->create([
            'flower_id' => $flowerId,
            'fertilizer_id' => $fertilizer->id,
            'period' => $period,
            'amount' => 1,
            'last_fertilizer_date' => Carbon::yesterday(),
            'next_fertilizer_date' => $nextFertilize ?? Carbon::yesterday()->addDays($period),
        ]);
    }

    public function createFertizilingReport(User $user, Flower $flower)
    {
        $flowerFertilizer = $this->createFlowerFertilizerConfigs($flower->id, 1);

        $flower->fertazilingReport()->attach($flowerFertilizer->id, ['user_id' => $user->id]);

        return $flowerFertilizer;
    }
}