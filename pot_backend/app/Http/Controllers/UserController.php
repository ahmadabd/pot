<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\Token\Token;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;

class UserController extends Controller
{
    public function __construct(
        private Token $tokenManager,
        private ?Authenticatable $currentUser
    ){}

    public function login(UserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (empty($user) || !$this->tokenManager->checkToken($request->password, $user)) {
            throw new AuthorizationException('Username or Password is incorrect', 401);
        } 

        $result = [
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $user->createToken('token')->plainTextToken,
        ];

        return response()->json($result, 200);
    }

    public function register(UserRequest $request)
    {
        if (User::where('email', $request->email)->exists()) {
            throw new AuthorizationException('User already exists', 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $this->tokenManager->createToken($request->password),
        ]);

        if ($user) {
            $result = [
                'status' => 'success',
                'message' => 'User created successfully',
            ];
            
            return response()->json($result, 201);
        } 
    }

    public function logout()
    {
        $this->tokenManager->destroyToken($this->currentUser);

        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful',
        ], 200);
    }
}
