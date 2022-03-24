<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlowerRequest;
use App\Repositories\Flower\FlowerRepositoryInterface;
use App\Models\Flower;
use Illuminate\Http\Request;

class FlowerController extends Controller
{
    public function __construct(private FlowerRepositoryInterface $flowerRepository){}

    public function getFlower(Request $request, int $id)
    {
        $result = [
            'status' => 'success',
            'message' => 'Flower get successfully',
        ];

        $result["data"] = $this->flowerRepository->getFlower($request->user, $id);

        return response()->json($result, 200);
    }


    public function getFlowers(Request $request)
    {
        $result = [
            'status' => 'success',
            'message' => 'Flower get successfully',
        ];

        $result["data"] = $this->flowerRepository->getFlowers($request->user, $request->get('paginationLimit'));

        return response()->json($result, 200);
    }


    public function create(FlowerRequest $request)
    {
        $this->flowerRepository->createFlower($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Flower created successfully',
        ], 201);
    }


    public function update(FlowerRequest $request, Flower $flower)
    {
        $this->authorize('change', $flower);

        $this->flowerRepository->updateFlower($request, $flower);

        return response()->json([
            'status' => 'success',
            'message' => 'Flower updated successfully'
        ], 201);
    }


    public function delete(Request $request, Flower $flower)
    {
        $this->authorize('change', $flower);
        
        $this->flowerRepository->deleteFlower($flower);

        return response()->json([
            'status' => 'success',
            'message' => 'Flower deleted successfully'
        ], 201);
    }
}
