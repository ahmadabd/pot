<?php

namespace App\Repositories\Flower;

use App\Models\Flower;
use App\Models\User;

interface FlowerRepositoryInterface
{
    public function getFlower(User $user, int $id);

    public function getFlowers(User $user, ?int $paginationLimit);

    public function createFlower($request);

    public function updateFlower($request, Flower $flower);

    public function deleteFlower(Flower $flower);
}