<?php

namespace App\Repositories\FertilizingReport;

use App\Models\Flower;
use App\Models\User;

class FertilizingReportRepository implements FertilizingReportRepositoryInterface
{
    public function getFertilizingReportForAllFlowers(User $user, ?int $paginationLimit) 
    {
        return $user->flowers()
            ->with('fertazilingReport')
            ->with('flowerFertilizers.fertilizers')
            ->paginate($paginationLimit ?? 12);
    }

    public function getFertilizingReportForFlower(User $user, Flower $flower, ?int $paginationLimit)
    {
        return Flower::where('id', $flower->id)
            ->whereHas('users', fn($query) => 
                $query->where('user_id', $user->id)
            )
            ->with('fertazilingReport')
            ->with('flowerFertilizers.fertilizers')
            ->paginate($paginationLimit ?? 12);
    }
}