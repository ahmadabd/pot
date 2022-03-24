<?php

namespace App\Repositories\Watering;

use App\Models\Flower;

interface WateringRepositoryInterface
{
    public function AddWateringPeriod(int $period, int $flowerId): void;

    public function FlowerWatering(Flower $flower): void;
}