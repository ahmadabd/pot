<?php

namespace App\Repositories\FertilizingReport;

use App\Models\Flower;
use App\Models\User;

interface FertilizingReportRepositoryInterface
{
    public function getFertilizingReportForAllFlowers(User $user, ?int $paginationLimit);

    public function getFertilizingReportForFlower(User $user, Flower $flower, ?int $paginationLimit);
}