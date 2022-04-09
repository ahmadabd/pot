<?php

namespace App\Repositories\Report;

use App\Models\Flower;
use App\Models\User;

interface ReportRepositoryInterface
{
    public function getAllFlowerReports(User $user, ?int $paginationLimit);

    public function getFlowerReports(User $user, Flower $flower, ?int $paginationLimit);

    public function addFlowerReport(User $user, Flower $flower, $request);
}