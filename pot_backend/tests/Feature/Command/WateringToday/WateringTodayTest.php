<?php

namespace Tests\Feature\Command\WateringToday;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Tests\TestCase;
use Tests\Utilities\UsefullTools;

class WateringTodayTest extends TestCase
{
    use RefreshDatabase;
    use UsefullTools;
    use WateringTodayFactories;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->AuthenticatedUser();

        // Mocking
        Notification::fake();
        Log::shouldReceive('info')->andReturn(true);
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    /** @test */
    public function check_watering_today_command()
    {
        $this->createFlowerUser($this->user, 4);

        $this->artisan('watering:today')
            ->assertSuccessful();
    }
}
