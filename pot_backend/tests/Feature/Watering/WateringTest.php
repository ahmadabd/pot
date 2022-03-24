<?php

namespace Tests\Feature\Watering;

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

        $this->assertDatabaseHas('waterings', [
            'flower_id' => $flower->id,
            'period' => 2
        ]);

        $this->assertSame(1, $flower->watering()->count());
        
        $response->assertExactJson([
            'status' => 'success',
            'message' => 'Period set successfully on watering',
        ]);
    }
}
