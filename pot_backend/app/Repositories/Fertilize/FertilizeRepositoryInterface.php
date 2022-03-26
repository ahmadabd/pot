<?php

namespace App\Repositories\Fertilize;

interface FertilizeRepositoryInterface
{
    public function addPeriodAndAmountToFlowerFertilize(int $flowerId, int $fertilizeId, int $period, float $amount);
}