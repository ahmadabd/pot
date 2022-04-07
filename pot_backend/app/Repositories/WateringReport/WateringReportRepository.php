<?php

namespace App\Repositories\WateringReport;

use App\Models\Flower;
use App\Models\User;

class WateringReportRepository implements WateringReportRepositoryInterface 
{
    public function getWateringReportForAllFlowers(User $user, ?int $paginationLimit)
    {
        return $user->flowers()
            ->with('wateringReport:id,flower_id')
            ->paginate($paginationLimit ?? 12);
    }

    public function getWateringReportForFlower(User $user, Flower $flower, ?int $paginationLimit) 
    {
        return Flower::where('id', $flower->id)
            ->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with('wateringReport:id,flower_id')
            ->paginate($paginationLimit ?? 12);
    }
}