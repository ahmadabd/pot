<?php

namespace Tests\Feature\Api\Flower;

use App\Models\Flower;
use App\Models\FlowerUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Utilities\UsefullTools;

class FlowerTest extends TestCase
{
    use RefreshDatabase;
    use FlowerFactories;
    use UsefullTools;

    /** @test */
    public function check_flower_create_validation_error()
    {
        $user = $this->AuthenticatedUser();

        $input = [
            'name' => '',
            'description' => 'A beautiful rose',
        ];

        $response = $this->postJson(route('flowers.create'), $input)
            ->assertStatus(400);

        $response->assertExactJson([
            "status" => "error",
            "message" => "Validation: A name is required"
        ]);
    }

    /** @test */
    public function check_flower_create()
    {
        $role = $this->createRole('owner');

        $user = $this->AuthenticatedUser();

        $input = [
            'name' => 'Rose',
            'description' => 'A beautiful rose',
        ];

        $response = $this->postJson(route('flowers.create'), $input)
            ->assertStatus(201);

        $this->assertSame(1, $user->flowers()->count());
       
        $response->assertExactJson([
            "status" => "success",
            "message" => "Flower created successfully"
        ]);
    }


    /** @test */
    public function check_flower_update_when_user_is_unauthorized()
    {
        $user = $this->AuthenticatedUser();
        
        $flower = $this->createFlowerUser(User::factory()->create());

        $input = [
            "name" => "Rose",
            "description" => "Rose is beautiful"
        ];

        $response = $this->putJson(route('flowers.update', [$flower->id]), $input)
            ->assertStatus(401);

        $response->assertExactJson([
            "status" => "error",
            "message" => "UnAuthorized: This action is unauthorized."
        ]);
    }


    /** @test */
    public function check_flower_update()
    {
        $user = $this->AuthenticatedUser();
        
        $flower = $this->createFlowerUser($user);

        $input = [
            "name" => "Rose",
            "description" => "Rose is beautiful"
        ];

        $response = $this->putJson(route('flowers.update', [$flower->id]), $input)
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
        $user = $this->AuthenticatedUser();

        $flower = $this->createFlowerUser($user);

        $response = $this->deleteJson(route('flowers.delete', [$flower->id]))
            ->assertStatus(201);

        $this->assertSame(0, FlowerUser::where('flower_id', $flower->id)->count());

        $response->assertExactJson([
            "status" => "success",
            "message" => "Flower deleted successfully"
        ]);
    }


    /** @test */
    public function check_flower_delete_unauthorized()
    {
        $user = $this->AuthenticatedUser();

        $flower = $this->createFlowerUser(User::factory()->create());

        $response = $this->deleteJson(route('flowers.delete', [$flower->id]))
            ->assertStatus(401);

        $response->assertExactJson([
            "status" => "error",
            "message" => "UnAuthorized: This action is unauthorized."
        ]);
    }

    /** @test */
    public function check_get_flower()
    {
        $user = $this->AuthenticatedUser();

        $flower = $this->createFlowerUser($user);

        $watering = $this->createWatering($flower->id, 4);
        $fertilizer = $this->createFertilizer($flower->id, 30);

        $response = $this->getJson(route('flowers.get', [$flower->id]));

        $response->assertJson([
            'status' => 'success',
            'message' => 'Flower get successfully',
            'data' => [
                'id' => $flower->id,
                'watering' => [
                    'id' => $watering->id,
                ],
                'flower_fertilizers' => [
                    [
                        'id' => $fertilizer->id,
                        'flower_id' => $flower->id,
                        'fertilizers' => [
                            'id' => $fertilizer->fertilizers()->first()->id,
                            'name' => $fertilizer->fertilizers()->first()->name,
                        ]
                    ],
                ]
            ]
        ]);
    }


    /** @test */
    public function check_get_flower_that_is_now_users_flower()
    {
        $user = $this->AuthenticatedUser();

        $flower = $this->createFlowerUser(User::factory()->create());

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
        $user = $this->AuthenticatedUser();

        $response = $this->getJson(route('flowers.getAll'));

        $response->assertJson([
            'status' => 'success',
            'message' => 'Flower get successfully',
            'data' => [
                "total" => 0,
                "lastPage" => 1,
                "perPage" => "12",
                "currentPage" => 1,
                "items" => []
            ]
        ]);
    }

    /** @test */
    public function check_get_flowers()
    {
        $user = $this->AuthenticatedUser();

        $flowers = $this->createFlowerUser($user);
        $watering = $this->createWatering($flowers->id, 4);
        $fertilizer = $this->createFertilizer($flowers->id, 30);

        $input = [
            'paginationLimit' => 5
        ];

        $response = $this->getJson(route('flowers.getAll', $input));

        $response->assertJson([
            'status' => 'success',
            'message' => 'Flower get successfully',
            'data' => [
                "total" => 1,
                "lastPage" => 1,
                "perPage" => "5",
                "currentPage" => 1,
                "items" => [
                    [
                        'id' => $flowers->id,
                        'watering' => [
                            'id' => $watering->id,
                        ],
                        'flower_fertilizers' => [
                            [
                                'id' => $fertilizer->id,
                                'fertilizers' => [
                                    'id' => $fertilizer->fertilizers()->first()->id,
                                    'name' => $fertilizer->fertilizers()->first()->name,
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
