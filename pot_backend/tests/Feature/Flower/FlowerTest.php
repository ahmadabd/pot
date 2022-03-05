<?php

namespace Tests\Feature\Flower;

use App\Models\Flower;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlowerTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function check_flower_create_validation_error()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $input = [
            'name' => '',
            'description' => 'A beautiful rose',
        ];

        $response = $this->post(route('flowers.create'), $input)
            ->assertStatus(400);

        $response->assertExactJson([
            "status" => "error",
            "message" => "Validation: A name is required"
        ]);
    }

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


    /** @test */
    public function check_flower_update_when_user_is_unauthorized()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $flower = Flower::factory()->create();

        $input = [
            "name" => "Rose",
            "description" => "Rose is beautiful"
        ];

        $response = $this->put(route('flowers.update', [$flower]), $input)
            ->assertStatus(401);

        $response->assertExactJson([
            "status" => "error",
            "message" => "UnAuthorized: This action is unauthorized."
        ]);
    }


    /** @test */
    public function check_flower_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $flower = Flower::factory()->create(['user_id' => $user->id]);

        $input = [
            "name" => "Rose",
            "description" => "Rose is beautiful"
        ];

        $response = $this->put(route('flowers.update', [$flower]), $input)
            ->assertStatus(201);
        
        $this->assertSame($input["name"], Flower::find($flower->id)->name);

        $response->assertExactJson([
            "status" => "success",
            "message" => "Flower updated successfully"
        ]);
    }
}
