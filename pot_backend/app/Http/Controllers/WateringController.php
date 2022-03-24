<?php

namespace App\Http\Controllers;

use App\Http\Requests\WateringRequest;
use App\Models\Flower;
use App\Repositories\Watering\WateringRepositoryInterface;

class WateringController extends Controller
{
    public function __construct(private WateringRepositoryInterface $flowerRepository){}

    public function addWateringToFlower(WateringRequest $request, Flower $flower)
    {
        $result = [
            'status' => 'success',
            'message' => 'Period set successfully on watering',
        ];

        $this->authorize('change', $flower);
        
        $this->flowerRepository->AddWateringPeriod($request->validated()['period'], $flower->id);

        return response()->json($result, 201);
    }
}
