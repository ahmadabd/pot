<?php

namespace Tests\Feature\Watering;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utilities\UsefullTools;

class WateringTest extends TestCase
{
    use RefreshDatabase;
    use WateringFactory;
    use UsefullTools;

    /** @test */
    public function check_watering_add_to_flower()
    {
        $user = $this->AuthenticatedUser();

        $flower = $this->createFlowerUser($user);

        $response = $this->postJson(route('watering.add', [$flower->id]), ['period' => 2])
            ->assertStatus(201);

        
    }
}
