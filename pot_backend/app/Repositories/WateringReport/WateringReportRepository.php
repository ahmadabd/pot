<?php

namespace App\Repositories\WateringReport;

use App\Models\User;

class WateringReportRepository implements WateringReportRepositoryInterface 
{
    public function getWateringReportForAllFlowers(User $user, ?int $paginationLimit)
    {
        return $user->flowers()
            ->with('wateringReport:id,flower_id')
            ->paginate($paginationLimit ?? 12);
    }
}