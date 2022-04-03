<?php

namespace Tests\Feature\Command\FertilizingToday;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Tests\TestCase;
use Tests\Utilities\UsefullTools;

class FertilizingTodayTest extends TestCase
{
    use RefreshDatabase;
    use UsefullTools;
    use FertilizingTodayFactories;

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
    public function check_fertilizing_today_command()
    {
        $this->createFlowerUser($this->user);        

        $this->artisan('fertilizing:today')
            ->assertSuccessful();
    }
}
