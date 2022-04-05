<?php

namespace App\Repositories\Watering;

use App\Models\Flower;
use App\Models\User;

interface WateringRepositoryInterface
{
    public function AddWateringPeriod(int $period, int $flowerId): void;

    public function FlowerWatering(User $user, Flower $flower): void;

    public function getUserTodoyWatering(User $user, ?int $paginationLimit);

    public function getTodoyWatering();
}