<?php

namespace App\Repositories\Report;

use App\Models\Flower;
use App\Models\Report;
use App\Models\User;

class ReportRepository implements ReportRepositoryInterface
{
    public function getAllFlowerReports(User $user, ?int $paginationLimit)
    {
        return $user->flowers()->with('reports')->paginate($paginationLimit ?? 12);
    }

    public function getFlowerReports(User $user, Flower $flower, ?int $paginationLimit)
    {
        return Flower::where('id', $flower->id)
            ->whereHas('users', fn($query) => 
                $query->where('user_id', $user->id)
            )
            ->with('reports')
            ->paginate($paginationLimit ?? 12);
    }

    public function addFlowerReport(User $user, Flower $flower, $request)
    {
        Report::create([
            'flower_id' => $flower->id,
            'height' => $request->height,
            'temperature' => $request->temperature,
            'humidity' => $request->humidity,
        ]);
    }
}