<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlowerRequest;
use App\Models\Flower;

class FlowerController extends Controller
{
    public function create(FlowerRequest $request)
    {
        $flower = Flower::create([
            'name' => $request->validated()['name'],
            'description' => $request->validated()['description'],
            'user_id' => $request->user->id,
        ]);

        if ($flower) {
            return response()->json([
                'status' => 'success',
                'message' => 'Flower created successfully',
            ], 201);
        }
    }
}
