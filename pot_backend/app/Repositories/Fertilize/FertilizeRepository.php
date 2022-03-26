<?php

namespace App\Repositories\Fertilize;

use App\Models\Fertilizer;
use App\Models\FlowerFertilizer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FertilizeRepository implements FertilizeRepositoryInterface
{
    public function addPeriodAndAmountToFlowerFertilize(int $flowerId, int $fertilizeId, int $period, float $amount)
    {
        if (Fertilizer::where('id', $fertilizeId)->exists()) {
            FlowerFertilizer::create([
                'fertilizer_id' => $fertilizeId,
                'flower_id' => $flowerId,
                'period' => $period,
                'amount' => $amount,
            ]);
        } else {
            throw new ModelNotFoundException('Fertilize not found', 404);
        }
    }
}