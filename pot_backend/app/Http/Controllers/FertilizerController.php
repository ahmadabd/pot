<?php

namespace App\Http\Controllers;

use App\Http\Requests\FertilizerRequest;
use App\Http\Requests\FlowerFertilizerRequest;
use App\Models\Flower;
use App\Repositories\Fertilize\FertilizeRepositoryInterface;
use Illuminate\Http\Request;

class FertilizerController extends Controller
{
    public function __construct(private FertilizeRepositoryInterface $fertilizeRepository){}


    public function createFertilizer(FertilizerRequest $request)
    {
        $result = [
            'status' => 'success',
            'message' => 'Fertilizer added successfully',
        ];
        
        $this->fertilizeRepository->create($request->validated()['name']);

        return response()->json($result, 201);
    }


    public function getFertilizers(Request $request)
    {
        $result = [
            'status' => 'success',
            'message' => 'Fertilizers get successfully',
        ];

        $fertilizers = $this->fertilizeRepository->getFertilizers($request->get('paginationLimit'));

        $result["data"] = [
            'total' => $fertilizers->total(),
            'lastPage' => $fertilizers->lastPage(),
            'perPage' => $fertilizers->perPage(),
            'currentPage' => $fertilizers->currentPage(),
            'items' => $fertilizers->items(),
        ];

        return response()->json($result, 200);
        
    }


    public function addFlowerFertilizerPeriodANDAmount(FlowerFertilizerRequest $request, Flower $flower)
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

    public function fertilizingFlower(Flower $flower)
    {
        $result = [
            'status' => 'success',
            'message' => 'Flower fertilized successfully',
        ];

        $this->fertilizeRepository->flowerFertalizing($flower);

        return response()->json($result, 201);
    }
}
