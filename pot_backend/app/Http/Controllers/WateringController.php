<?php

namespace App\Http\Controllers;

use App\Http\Requests\WateringRequest;
use App\Models\Flower;
use App\Models\Watering;
use App\Repositories\Watering\WateringRepositoryInterface;
use Illuminate\Http\Request;

class WateringController extends Controller
{
    public function __construct(private WateringRepositoryInterface $wateringRepository){}

    public function addWateringPeriod(WateringRequest $request, Flower $flower)
    {
        $result = [
            'status' => 'success',
            'message' => 'Period set successfully on watering',
        ];

        $this->authorize('change', $flower);
        
        $this->wateringRepository->AddWateringPeriod($request->validated()['period'], $flower->id);

        return response()->json($result, 201);
    }


    public function wateringFlower(Request $request, Flower $flower)
    {
        $result = [
            'status' => 'success',
            'message' => 'Flower watered successfully',
        ];

        $this->wateringRepository->FlowerWatering($request->user, $flower);

        return response()->json($result, 201);
    }


    public function getUserTodoyWatering(Request $request)
    {
        $result = [
            'status' => 'success',
            'message' => 'Get user todays watering flowers',
        ];

        $flowers = $this->wateringRepository->getUserTodoyWatering($request->user(), $request->get('paginationLimit'));

        $result["data"] = [
            'total' => $flowers->total(),
            'lastPage' => $flowers->lastPage(),
            'perPage' => $flowers->perPage(),
            'currentPage' => $flowers->currentPage(),
            'items' => $flowers->items(),
        ];

        return response()->json($result, 200);
    }


    public function getTodoyWatering(Request $request)
    {
        $result = [
            'status' => 'success',
            'message' => 'Get all todays watering flowers',
        ];

        $result["data"] = $this->wateringRepository->getTodoyWatering();

        return response()->json($result, 200);
    }
}
