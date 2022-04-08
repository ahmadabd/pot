<?php

namespace Tests\Feature\Api\FertilizingReport;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utilities\UsefullTools;

class FertilizingReportTest extends TestCase
{
    use RefreshDatabase;
    use UsefullTools;
    use FertilizingReportFactories;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->AuthenticatedUser();
    }

    /** @test */
    public function check_getFertilizingReports()
    {
        $flower = $this->createFlowerUser($this->user);
        $flowerFertilizer = $this->createFertizilingReport($this->user, $flower);

        $response = $this->getJson(route('fertilizing.reports'))
            ->assertStatus(200);

        $response->assertJson([
            "status" => "success",
            "message" => "Watering report for all flowers",
            "data" => [
                "total" => 1,
                "lastPage" => 1,
                "perPage" => 12,
                "currentPage" => 1,
                "items" => [
                    [
                        "id" => $flower->id,
                        "fertaziling_report" => [
                            [
                                "id" => $flower->fertazilingReport()->first()->id
                            ]
                        ],
                        "flower_fertilizers" => [
                            [
                                "id" => $flowerFertilizer->id,
                                "fertilizers" => [
                                    "id" => $flowerFertilizer->fertilizers()->first()->id,
                                    "name" => $flowerFertilizer->fertilizers()->first()->name
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function check_getFertilizingReport()
    {
        $flower = $this->createFlowerUser($this->user);
        $flowerFertilizer = $this->createFertizilingReport($this->user, $flower);

        $response = $this->getJson(route('fertilizing.report', ['flower' => $flower->id]))
            ->assertStatus(200);

        $response->assertJson([
            "status" => "success",
            "message" => "Watering report for all flowers",
            "data" => [
                "total" => 1,
                "lastPage" => 1,
                "perPage" => 12,
                "currentPage" => 1,
                "items" => [
                    [
                        "id" => $flower->id,
                        "fertaziling_report" => [
                            [
                                "id" => $flower->fertazilingReport()->first()->id
                            ]
                        ],
                        "flower_fertilizers" => [
                            [
                                "id" => $flowerFertilizer->id,
                                "fertilizers" => [
                                    "id" => $flowerFertilizer->fertilizers()->first()->id,
                                    "name" => $flowerFertilizer->fertilizers()->first()->name
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
