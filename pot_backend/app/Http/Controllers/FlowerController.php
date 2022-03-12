<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlowerRequest;
use App\Models\Flower;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlowerController extends Controller
{
    public function getFlower(Request $request, int $id)
    {
        $result = [
            'status' => 'success',
            'message' => 'Flower get successfully',
        ];

        $user = $request->user;
        $flower = $user->flowers()->where('flower_id', $id)
            ->with(['watering', 'flowerFertilizers.fertilizers'])->firstOrFail();

        $result["data"] = $flower;

        return response()->json($result, 200);
    }

    public function getFlowers(Request $request)
    {
        // Should return watering and fertazile date too
        
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
        DB::transaction(function() use($request) {
            $flower = Flower::create([
                'name' => $request->validated()['name'],
                'description' => $request->validated()['description'],
            ]);

            $flower->users()->attach($request->user, ['role_id' => Role::owner()->first()->id]);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Flower created successfully',
        ], 201);
    }

    public function update(FlowerRequest $request, Flower $flower)
    {
        $this->authorize('change', $flower);

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
        $this->authorize('change', $flower);
        
        $flower->deleteOrFail();

        return response()->json([
            'status' => 'success',
            'message' => 'Flower deleted successfully'
        ], 201);
    }
}
