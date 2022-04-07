<?php

namespace App\Repositories\WateringReport;

use App\Models\Flower;
use App\Models\User;

interface WateringReportRepositoryInterface
{
    public function getWateringReportForAllFlowers(User $user, ?int $paginationLimit);

    public function getWateringReportForFlower(User $user, Flower $flower, ?int $paginationLimit);
}