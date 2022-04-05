<?php

namespace App\Repositories\WateringReport;

use App\Models\User;

interface WateringReportRepositoryInterface
{
    public function getWateringReportForAllFlowers(User $user, ?int $paginationLimit);
}