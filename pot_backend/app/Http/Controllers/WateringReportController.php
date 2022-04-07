<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use App\Repositories\WateringReport\WateringReportRepositoryInterface;
use Illuminate\Http\Request;

class WateringReportController extends Controller
{
    public function __construct(private WateringReportRepositoryInterface $repository) {}

    public function getWateringReports(Request $request)
    {
        $result = [
            "status" => "success",
            "message" => "Watering report for all flowers",
        ];

        $flowers = $this->repository->getWateringReportForAllFlowers($request->user, $request->get('paginationLimit'));

        $result["data"] = [
            'total' => $flowers->total(),
            'lastPage' => $flowers->lastPage(),
            'perPage' => $flowers->perPage(),
            'currentPage' => $flowers->currentPage(),
            'items' => $flowers->items(),
        ];

        return response()->json($result, 200);
    }

    public function getWateringReport(Request $request, Flower $flower)
    {
        $result = [
            "status" => "success",
            "message" => "Watering report for all flowers",
        ];

        $flowers = $this->repository->getWateringReportForFlower($request->user, $flower, $request->get('paginationLimit'));

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
