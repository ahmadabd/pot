<?php

namespace App\Interfaces;

use App\Models\Flower;
use App\Models\User;

interface FlowerRepositoryInterface
{
    public function getFlower(User $user, int $id);

    public function getFlowers(User $user, ?int $paginationLimit) : array;

    public function createFlower($request);

    public function updateFlower($request, Flower $flower);

    public function deleteFlower(Flower $flower);
}