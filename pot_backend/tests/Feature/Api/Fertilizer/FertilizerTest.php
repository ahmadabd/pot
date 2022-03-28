<?php

namespace Tests\Feature\Api\Fertilizer;

use App\Models\Fertilizer;
use App\Models\FertilizerReport;
use App\Models\FlowerFertilizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utilities\UsefullTools;

class FertilizerTest extends TestCase
{
    use RefreshDatabase;
    use FertilizerFactories;
    use UsefullTools;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->AuthenticatedUser();
    }


    /** @test */
    public function check_add_period_and_amount_on_flowerFertilizer_without_fertilizeId()
    {
        $flower = $this->createFlowerUser($this->user);

        $response = $this->postJson(route('fertilizer.period.add', [$flower->id]), ['period' => 2, 'amount' => 2.1])
            ->assertStatus(400);

        $response->assertExactJson([
            "status" => "error",
            "message" => "Validation: Fertilizer is required"
        ]);
    }


    /** @test */
    public function check_add_period_and_amount_on_flowerFertilizer_with_wrong_fertilizeId()
    {
        $flower = $this->createFlowerUser($this->user);

        $response = $this->postJson(route('fertilizer.period.add', [$flower->id]), ['fertilize' => 1, 'period' => 2, 'amount' => 2.1])
            ->assertStatus(404);

        $response->assertExactJson([
            "status" => "error",
            "message" => "ModelNotFound: Fertilize not found"
        ]);
    }

    /** @test */
    public function check_add_period_and_amount_on_flowerFertilizer()
    {
        $flower = $this->createFlowerUser($this->user);
        $fertilize = $this->createFertilizer();

        $response = $this->postJson(route('fertilizer.period.add', [$flower->id]), ['fertilize' => $fertilize->id, 'period' => 2, 'amount' => 2.1])
            ->assertStatus(201);

        $this->assertSame("2", FlowerFertilizer::where('flower_id', $flower->id)->where('fertilizer_id', $fertilize->id)->first()->period);

        $response->assertExactJson([
            "status" => "success",
            "message" => "Period and Amount set successfully on Fertilize"
        ]);
    }


    /** @test */
    public function check_flower_fertilizing_without_flowerFertaziler_configs()
    {
        $flower = $this->createFlowerUser($this->user);
        $this->createFertilizer();

        $response = $this->postJson(route('fertilizing.add', [$flower->id]))
            ->assertStatus(404);

        $response->assertExactJson([
            "status" => "error",
            "message" => "ModelNotFound: There is not set fertilizing configs for this flower"
        ]);
    }


    /** @test */
    public function check_flower_fertilizing()
    {
        $flower = $this->createFlowerUser($this->user);
        $flowerFertilizer = $this->createFlowerFertilizerConfigs($flower->id, 4);

        $response = $this->postJson(route('fertilizing.add', [$flower->id]))
            ->assertStatus(201);

        $this->assertSame(1, FlowerFertilizer::where('id', $flowerFertilizer->id)->where('flower_id', $flower->id)->count());
        $this->assertSame(1, FertilizerReport::where('flower_id', $flower->id)->count());

        $response->assertExactJson([
            "status" => "success",
            "message" => "Flower fertilized successfully"
        ]);
    }


    /** @test */
    public function check_add_fertilizer()
    {
        $fertilizerName = 'animaly';

        $response = $this->postJson(route('fertilizer.add'), ['name' => $fertilizerName])
            ->assertStatus(201);

        $this->assertSame($fertilizerName, Fertilizer::first()->name);

        $response->assertExactJson([
            "status" => "success",
            "message" => "Fertilizer added successfully"
        ]);
    }


    /** @test */
    public function check_getAll_fertilizers()
    {
        $fertilizers = Fertilizer::factory(10)->create();
    
        $response = $this->getJson(route('fertilizer.getAll'))
            ->assertStatus(200);

        $response->assertJson([
            "status" => "success",
            "message" => "Fertilizers get successfully",
            "data" => [
                "total" => 10,
                "lastPage" => 1,
                "perPage" => 12,
                "currentPage" => 1,
                "items" => [
                    [
                        'id' => $fertilizers[0]->id,
                        'name' => $fertilizers[0]->name,
                    ]
                ]
            ]
        ]);
    }


    /** @test */
    public function check_getAll_fertilizers_with_pahination()
    {
        $fertilizers = Fertilizer::factory(10)->create();
    
        $response = $this->getJson(route('fertilizer.getAll', ['paginationLimit' => 5]))
            ->assertStatus(200);

        $response->assertJson([
            "status" => "success",
            "message" => "Fertilizers get successfully",
            "data" => [
                "total" => 10,
                "lastPage" => 2,
                "perPage" => 5,
                "currentPage" => 1,
                "items" => [
                    [
                        'id' => $fertilizers[0]->id,
                        'name' => $fertilizers[0]->name,
                    ]
                ]
            ]
        ]);
    }
}
