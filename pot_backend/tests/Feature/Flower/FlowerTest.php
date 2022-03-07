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

    /** @test */
    public function check_flower_delete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $flower = Flower::factory()->create(['user_id' => $user->id]);

        $response = $this->delete(route('flowers.delete', [$flower]))
            ->assertStatus(201);

        $this->assertSame(0, $user->flowers()->count());

        $response->assertExactJson([
            "status" => "success",
            "message" => "Flower deleted successfully"
        ]);
    }


    /** @test */
    public function check_flower_delete_unauthorized()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $flower = Flower::factory()->create();

        $response = $this->deleteJson(route('flowers.delete', [$flower]))
            ->assertStatus(401);

        $response->assertExactJson([
            "status" => "error",
            "message" => "UnAuthorized: This action is unauthorized."
        ]);
    }

    /** @test */
    public function check_get_flower()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $flower = Flower::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson(route('flowers.get', [$flower->id]));

        $response->assertJson([
            'status' => 'success',
            'message' => 'Flower get successfully',
            'data' => [
                'id' => $flower->id
            ]
        ]);
    }


    /** @test */
    public function check_get_flower_that_is_now_users_flower()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $flower = Flower::factory()->create();

        $response = $this->getJson(route('flowers.get', [$flower->id]))
            ->assertStatus(404);

        $response->assertExactJson([
            "status" => "error",
            "message" => "ModelNotFound: No query results for model [App\\Models\\Flower]."
        ]);
    }

    /** @test */
    public function check_get_flowers_when_list_is_empty()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson(route('flowers.getAll'));

        $response->assertJson([
            'status' => 'success',
            'message' => 'Flower get successfully',
            'data' => [
                "total" => 0,
                "lastPage" => 1,
                "perPage" => "5",
                "currentPage" => 1,
                "items" => []
            ]
        ]);
    }

    /** @test */
    public function check_get_flowers()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $flowers = Flower::factory(10)->create(['user_id' => $user->id]);

        $input = [
            'paginationLimit' => 5
        ];

        $response = $this->getJson(route('flowers.getAll', $input));

        $response->assertJson([
            'status' => 'success',
            'message' => 'Flower get successfully',
            'data' => [
                "total" => 10,
                "lastPage" => 2,
                "perPage" => "5",
                "currentPage" => 1,
                "items" => [
                    ['id' => $flowers[0]->id]
                ]
            ]
        ]);
    }
}
