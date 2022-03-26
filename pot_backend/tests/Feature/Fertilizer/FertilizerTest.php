<?php

namespace Tests\Feature\Fertilizer;

use App\Models\FertilizerReport;
use App\Models\FlowerFertilizer;
use Carbon\Carbon;
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
    public function check_add_period_and_amount_on_fertilize_without_fertilizeId()
    {
        $flower = $this->createFlowerUser($this->user);

        $response = $this->postJson(route('fertilize.period.add', [$flower->id]), ['period' => 2, 'amount' => 2.1])
            ->assertStatus(400);

        $response->assertExactJson([
            "status" => "error",
            "message" => "Validation: Fertilizer is required"
        ]);
    }


    /** @test */
    public function check_add_period_and_amount_on_fertilize_with_wrong_fertilizeId()
    {
        $flower = $this->createFlowerUser($this->user);

        $response = $this->postJson(route('fertilize.period.add', [$flower->id]), ['fertilize' => 1, 'period' => 2, 'amount' => 2.1])
            ->assertStatus(404);

        $response->assertExactJson([
            "status" => "error",
            "message" => "ModelNotFound: Fertilize not found"
        ]);
    }

    /** @test */
    public function check_add_period_and_amount_on_fertilize()
    {
        $flower = $this->createFlowerUser($this->user);
        $fertilize = $this->createFertilize();

        $response = $this->postJson(route('fertilize.period.add', [$flower->id]), ['fertilize' => $fertilize->id, 'period' => 2, 'amount' => 2.1])
            ->assertStatus(201);

        $this->assertSame("2", FlowerFertilizer::where('flower_id', $flower->id)->where('fertilizer_id', $fertilize->id)->first()->period);

        $response->assertExactJson([
            "status" => "success",
            "message" => "Period and Amount set successfully on Fertilize"
        ]);
    }


    /** @test */
    public function check_flower_fertilizing_without_flower_fertaziler_configs()
    {
        $flower = $this->createFlowerUser($this->user);
        $fertilize = $this->createFertilize();

        $response = $this->postJson(route('fertilize.add', [$flower->id]))
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
        $flowerFertilizer = $this->createFertilizerConfigs($flower->id, 4);

        $response = $this->postJson(route('fertilize.add', [$flower->id]))
            ->assertStatus(201);

        $this->assertSame(1, FlowerFertilizer::where('flower_id', $flower->id)->count());
        $this->assertSame(1, FertilizerReport::where('flower_id', $flower->id)->count());

        $response->assertExactJson([
            "status" => "success",
            "message" => "Flower fertilized successfully"
        ]);
    }
}
