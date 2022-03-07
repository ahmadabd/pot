<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlowerRequest;
use App\Models\Flower;
use Illuminate\Http\Request;

class FlowerController extends Controller
{
    public function getFlower(Request $request, int $id)
    {
        $result = [
            'status' => 'success',
            'message' => 'Flower get successfully',
        ];

        $user = $request->user;
        $flower = $user->flowers()->where('id', $id)->firstOrFail();

        $result["data"] = $flower;

        return response()->json($result, 200);
    }

    public function getFlowers(Request $request)
    {
        $result = [
            'status' => 'success',
            'message' => 'Flower get successfully',
        ];

        $paginationLimit = $request->get('paginationLimit') ?? 5;

        $user = $request->user;
        $flowers = $user->flowers()->paginate($paginationLimit);

        $data = [
            'total' => $flowers->total(),
            'lastPage' => $flowers->lastPage(),
            'perPage' => $flowers->perPage(),
            'currentPage' => $flowers->currentPage(),
            'items' => $flowers->items(),
        ];

        $result["data"] = $data;

        return response()->json($result, 200);
    }

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

    public function update(FlowerRequest $request, Flower $flower)
    {
        $this->authorize('access', $flower);

        $flower->updateOrFail([
            'name' => $request->validated()['name'],
            'description' => $request->validated()['description']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Flower updated successfully'
        ], 201);
    }

    public function delete(Request $request, Flower $flower)
    {
        $this->authorize('access', $flower);
        
        $flower->deleteOrFail();

        return response()->json([
            'status' => 'success',
            'message' => 'Flower deleted successfully'
        ], 201);
    }
}
