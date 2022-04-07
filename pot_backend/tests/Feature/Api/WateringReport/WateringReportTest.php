<?php

namespace Tests\Feature\Api\WateringReport;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utilities\UsefullTools;

class WateringReportTest extends TestCase
{
    use RefreshDatabase;
    use UsefullTools;
    use WateringReportFactories;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->AuthenticatedUser();
    }

    /** @test */
    public function check_get_watering_report_for_all_flowers()
    {
        $flower = $this->createFlowerUser($this->user);
        $wateringReport = $this->createWateringReport($flower->id, $this->user->id);

        $response = $this->getJson(route('watering.reports'))
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
                        "name" => $flower->name,
                        "watering_report" => [
                            [
                                "id" => $wateringReport->watering_id,
                                "pivot" => [
                                    "flower_id" => $flower->id,
                                    "watering_id" => $wateringReport->watering_id
                                ]
                            ]
                        ],
                        "pivot" => [
                            "user_id" => $this->user->id
                        ]
                    ]
                ]
            ]
        ]);
    }


    /** @test */
    public function check_get_watering_report_flower()
    {
        $flower = $this->createFlowerUser($this->user);
        $wateringReport = $this->createWateringReport($flower->id, $this->user->id);

        $response = $this->getJson(route('watering.report', ['flower' => $flower->id]))
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
                        "name" => $flower->name,
                        "watering_report" => [
                            [
                                "id" => $wateringReport->watering_id,
                                "pivot" => [
                                    "flower_id" => (string)$flower->id,
                                    "watering_id" => (string)$wateringReport->watering_id
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
