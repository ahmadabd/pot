<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use App\Repositories\FertilizingReport\FertilizingReportRepositoryInterface;
use Illuminate\Http\Request;

class FertilizerReportController extends Controller
{
    public function __construct(private FertilizingReportRepositoryInterface $repository) {}

    public function getFertilizingReports(Request $request)
    {
        $result = [
            "status" => "success",
            "message" => "Watering report for all flowers",
        ];

        $flowers = $this->repository->getFertilizingReportForAllFlowers($request->user, $request->get('paginationLimit'));

        $result["data"] = [
            'total' => $flowers->total(),
            'lastPage' => $flowers->lastPage(),
            'perPage' => $flowers->perPage(),
            'currentPage' => $flowers->currentPage(),
            'items' => $flowers->items(),
        ];

        return response()->json($result, 200);
    }

    public function getFertilizingReport(Request $request, Flower $flower)
    {
        $result = [
            "status" => "success",
            "message" => "Watering report for all flowers",
        ];

        $flowers = $this->repository->getFertilizingReportForFlower($request->user, $flower, $request->get('paginationLimit'));

        $result["data"] = [
            'total' => $flowers->total(),
            'lastPage' => $flowers->lastPage(),
            'perPage' => $flowers->perPage(),
            'currentPage' => $flowers->currentPage(),
            'items' => $flowers->items(),
        ];

        return response()->json($result, 200);
    }
}
