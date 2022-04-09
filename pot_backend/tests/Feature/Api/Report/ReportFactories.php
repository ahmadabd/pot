<?php

namespace Tests\Feature\Api\Report;

use App\Models\Flower;
use App\Models\Report;
use App\Models\Role;
use App\Models\User;

trait ReportFactories
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

    public function createReportFlower(Flower $flower)
    {
        return Report::factory()->create([
            'flower_id' => $flower->id,
        ]);
    }
}