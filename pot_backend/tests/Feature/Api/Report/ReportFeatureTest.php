<?php

namespace Tests\Feature\Api\Report;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utilities\UsefullTools;

class ReportFeatureTest extends TestCase
{
    use RefreshDatabase;
    use UsefullTools;
    use ReportFactories;

    private $user;
    private $flower;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->AuthenticatedUser();
        $this->flower = $this->createFlowerUser($this->user);
    }

    /** @test */
    public function check_getAllFlowerReports()
    {
        $flowerReport = $this->createReportFlower($this->flower);

        $response = $this->getJson(route('report.flowers'));

        $response->assertJson([
            "status" => "success",
            "message" => "Return All Reports successfully",
            "data" => [
                "total" => 1,
                "lastPage" => 1,
                "perPage" => 12,
                "currentPage" => 1,
                "items" => [
                    [
                        "id" => $this->flower->id,
                        "name" => $this->flower->name,
                        "reports" => [
                            [
                                "id" => $flowerReport->id,
                                "height" => $flowerReport->height,
                                "temperature" => $flowerReport->temperature,
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }


    /** @test */
    public function check_getFlowerReports()
    {
        $flowerReport = $this->createReportFlower($this->flower);

        $response = $this->getJson(route('report.flower', ['flower' => $this->flower->id]));

        $response->assertJson([
            "status" => "success",
            "message" => "Report flower report successfully",
            "data" => [
                "total" => 1,
                "lastPage" => 1,
                "perPage" => 12,
                "currentPage" => 1,
                "items" => [
                    [
                        "id" => $this->flower->id,
                        "name" => $this->flower->name,
                        "reports" => [
                            [
                                "id" => $flowerReport->id,
                                "height" => $flowerReport->height,
                                "temperature" => $flowerReport->temperature,
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }


    /** @test */
    public function check_addFlowerReports()
    {
        $flowerReport = [
            'height' => 2.5,
            'temperature' => 3.5,
            'humidity' => 4.5,
        ];

        $response = $this->postJson(route('report.flower.add', ['flower' => $this->flower->id]), $flowerReport)
            ->assertStatus(201);

        $response->assertExactJson([
            'status' => 'success',
            'message' => 'Add new report for successfully',
        ]);
    }

    /** @test */
    public function check_addFlowerReports_validation()
    {
        $flowerReport = [
            'height' => 2.5,
            'temperature' => 3.5,
        ];

        $response = $this->postJson(route('report.flower.add', ['flower' => $this->flower->id]), $flowerReport)
            ->assertStatus(400);

        $response->assertExactJson([
            "status" => "error",
            "message" => "Validation: The humidity field is required."
        ]);
    }
}
