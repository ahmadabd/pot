<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Flower;
use App\Repositories\Report\ReportRepositoryInterface;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(private ReportRepositoryInterface $repository) {}

    public function getAllFlowerReports(Request $request)
    {
        $result = [
            'status' => 'success',
            'message' => 'Return All Reports successfully',
        ];

        $flowersReport = $this->repository->getAllFlowerReports($request->user, $request->get('paginationLimit'));

        $result['data'] = [
            'total' => $flowersReport->total(),
            'lastPage' => $flowersReport->lastPage(),
            'perPage' => $flowersReport->perPage(),
            'currentPage' => $flowersReport->currentPage(),
            'items' => $flowersReport->items(),
        ];

        return response()->json($result, 201);
    }


    public function getFlowerReports(Request $request, Flower $flower)
    {
        $result = [
            'status' => 'success',
            'message' => 'Report flower report successfully',
        ];

        $flowersReport = $this->repository->getFlowerReports($request->user, $flower, $request->get('paginationLimit'));

        $result['data'] = [
            'total' => $flowersReport->total(),
            'lastPage' => $flowersReport->lastPage(),
            'perPage' => $flowersReport->perPage(),
            'currentPage' => $flowersReport->currentPage(),
            'items' => $flowersReport->items(),
        ];

        return response()->json($result, 201);
    }


    public function addFlowerReport(ReportRequest $request, Flower $flower)
    {
        $this->authorize('change', $flower);

        $result = [
            'status' => 'success',
            'message' => 'Add new report for successfully',
        ];

        $this->repository->addFlowerReport($request->user, $flower, $request);

        return response()->json($result, 201);
    }
}
