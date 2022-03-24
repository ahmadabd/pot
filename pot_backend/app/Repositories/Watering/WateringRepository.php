<?php

namespace App\Repositories\Watering;

use App\Models\Watering;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WateringRepository implements WateringRepositoryInterface
{
    public function AddWateringPeriod(int $period, int $flowerId)
    {
        $watering = Watering::updateOrCreate(
            ['flower_id' => $flowerId],
            ['period' => $period]
        );

        if (!$watering) {
            throw new ModelNotFoundException('Error while saving watering period', 404);
        }
    }
}