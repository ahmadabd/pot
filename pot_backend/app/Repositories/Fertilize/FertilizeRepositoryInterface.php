<?php

namespace App\Repositories\Fertilize;

use App\Models\Flower;

interface FertilizeRepositoryInterface
{
    public function addPeriodAndAmountToFlowerFertilize(int $flowerId, int $fertilizeId, int $period, float $amount): void;

    public function flowerFertalizing(Flower $flower): void;

    public function create(string $name): void;

    public function getFertilizers(?int $paginationLimit);
}