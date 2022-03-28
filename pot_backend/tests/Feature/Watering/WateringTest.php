<?php

namespace Tests\Feature\Watering;

use App\Models\Watering;
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

        $watering = $this->createWatering($flower->id, 4);

        $response = $this->postJson(route('watering.add', [$flower->id]))
            ->assertStatus(201);

        $this->assertSame(1, $flower->watering()->count());
        
        $this->assertSame(1, $flower->wateringReport()->count());

        $response->assertExactJson([
            'status' => 'success',
            'message' => 'Flower watered successfully',
        ]);
    }


    /** @test */
    public function check_get_user_today_watering()
    {
        $flower = $this->createFlowerUser($this->user);

        $watering = Watering::factory()->create([
            'flower_id' => $flower->id,
            'period' => 2,
            'next_watering_date' => now()
        ]);

        $response = $this->getJson(route('watering.today'))
            ->assertStatus(200);

        $response->assertJson([
            "status" => "success",
            "message" => "Get user todays watering flowers",
            "data" => [
                "total" => 1,
                "lastPage" => 1,
                "perPage" => 12,
                "currentPage" => 1,
                "items" => [
                    [
                        "id" => $flower->id,
                        "name" => $flower->name
                    ]
                ]
            ]
        ]);
    }


    /** @test */
    public function check_get_today_watering()
    {
        $flower = $this->createFlowerUser($this->user);

        $watering = Watering::factory()->create([
            'flower_id' => $flower->id,
            'period' => 2,
            'next_watering_date' => now()
        ]);

        $response = $this->getJson(route('watering.today.all'))
            ->assertStatus(200);

        $response->assertJson([
            "status" => "success",
            "message" => "Get all todays watering flowers",
            "data" => [
                [
                    "id" => $flower->id,
                    "name" => $flower->name
                ]
            ]
        ]);
    }
}
