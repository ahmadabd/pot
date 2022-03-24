<?php

namespace App\Repositories\Watering;

interface WateringRepositoryInterface
{
    public function AddWateringPeriod(int $period, int $flowerId);
}