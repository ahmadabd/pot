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

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->AuthenticatedUser();
    }

    /** @test */
    public function check_watering_add_to_flower()
    {
        $flower = $this->createFlowerUser($this->user);

        $response = $this->postJson(route('watering.period.add', [$flower->id]), ['period' => 2])
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


    /** @test */
    public function check_flower_watering_when_flowersWatering_not_set()
    {
        $flower = $this->createFlowerUser($this->user);

        $response = $this->postJson(route('watering.add', [$flower->id]))
            ->assertStatus(404);

        $response->assertExactJson([
            "status" => "error",
            "message" => "ModelNotFound: There is not set watering configs for this flower"
        ]);
    }


    /** @test */
    public function check_flower_watering()
    {
        $flower = $this->createFlowerUser($this->user);

        $this->postJson(route('watering.period.add', [$flower->id]), ['period' => 4]);

        $response = $this->postJson(route('watering.add', [$flower->id]))
            ->assertStatus(201);

        $this->assertSame(1, $flower->watering()->count());
        
        $response->assertExactJson([
            'status' => 'success',
            'message' => 'Flower watered successfully',
        ]);
    }
}
