<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function check_user_registeration() 
    {
        $input = [
            'name' => 'John Doe',
            'email' => 'test@gmail.com',
            'password' => 'secret',
        ];

        $response = $this->post(route('register'), $input)
            ->assertStatus(201);

        $response->assertExactJson([
            "status" => "success",
            "message" => "User created successfully"
        ]);
    }


    /** @test */
    public function check_user_registeration_when_user_exists()
    {
        $input = [
            'name' => 'John Doe',
            'email' => 'test@gmail.com',
            'password' => 'secret',
        ];

        User::factory()->create([
            'email' => $input['email'],
        ]);

        $response = $this->post(route('register'), $input)
            ->assertStatus(401);

        $response->assertExactJson([
            "status" => "error",
            "message" => "UnAuthorized: User already exists"
        ]);
    }

    /** @test */
    public function check_user_login() 
    {
        $input = [
            'name' => 'John Doe',
            'email' => 'test@gmail.com',
            'password' => 'secret',
        ];

        // register
        $this->post(route('register'), $input);

        $response = $this->post(route('login'), $input)
            ->assertStatus(200);

        $response->assertJson([
            "status" => "success",
            "message" => "Login successful"
        ]);
    }


    /** @test */
    public function check_user_login_failure() 
    {
        $input = [
            'name' => 'John Doe',
            'email' => 'test@gmail.com',
            'password' => 'secret',
        ];

        // register
        $this->post(route('register'), $input);

        $response = $this->post(route('login'), [
            'name' => 'John Doe',
            'email' => 'test@gmail.com',
            'password' => 'wrong_password',
        ])->assertStatus(401);

        $response->assertExactJson([
            "status" => "error",
            "message" => "UnAuthorized: Username or Password is incorrect"
        ]);
    }


    /** @test */
    public function check_user_logout() 
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        
        $response = $this->delete(route('logout'));

        $response->assertExactJson([
            "status" => "success",
            "message" => "Logout successful"
        ]);
    }
}
