<?php

namespace App\Http\Controllers;

use App\Http\Requests\FertilizeRequest;
use App\Models\Flower;
use App\Repositories\Fertilize\FertilizeRepositoryInterface;

class FertilizerController extends Controller
{
    public function __construct(private FertilizeRepositoryInterface $fertilizeRepository){}

    public function addFertilizePeriodANDAmount(FertilizeRequest $request, Flower $flower)
    {
        $result = [
            'status' => 'success',
            'message' => 'Period and Amount set successfully on Fertilize',
        ];

        $this->authorize('change', $flower);

        $this->fertilizeRepository->addPeriodAndAmountToFlowerFertilize(
            $flower->id, 
            $request->validated()['fertilize'], 
            $request->validated()['period'], 
            $request->validated()['amount']
        );        
        
        return response()->json($result, 201);
    }
}
