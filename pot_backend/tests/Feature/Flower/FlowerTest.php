<?php

namespace Tests\Feature\Flower;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlowerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_flower_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $input = [
            'name' => 'Rose',
            'description' => 'A beautiful rose',
        ];

        $response = $this->post(route('flowers.create'), $input)
            ->assertStatus(201);

        $response->assertExactJson([
            "status" => "success",
            "message" => "Flower created successfully"
        ]);
    }
}
