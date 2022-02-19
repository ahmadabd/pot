<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\TokenManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private TokenManager $tokenManager,
        private ?Authenticatable $currentUser
    ){}

    public function login(UserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (empty($user) || !$this->tokenManager->checkToken($request->password, $user)) {
            $result = [
                'status' => 'error',
                'message' => 'Invalid credentials',
            ];

            return response()->json($result, 401);
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
        $user = User::firstOrCreate([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $this->tokenManager->createToken($request->password),
        ]);

        if ($user) {
            $result = [
                'status' => 'success',
                'message' => 'User created successfully',
            ];
        } 
        else {
            $result = [
                'status' => 'error',
                'message' => 'User not created',
            ];
        }

        return response()->json($result, 201);
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
