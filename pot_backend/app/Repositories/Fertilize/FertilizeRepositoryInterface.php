<?php

namespace App\Repositories\Fertilize;

use App\Models\Flower;

interface FertilizeRepositoryInterface
{
    public function addPeriodAndAmountToFlowerFertilize(int $flowerId, int $fertilizeId, int $period, float $amount): void;

    public function flowerFertalizing(Flower $flower): void;
}