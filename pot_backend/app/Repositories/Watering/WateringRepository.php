<?php

namespace App\Repositories\Watering;

use App\Models\Flower;
use App\Models\Watering;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WateringRepository implements WateringRepositoryInterface
{
    public function AddWateringPeriod(int $period, int $flowerId): void
    {
        $watering = Watering::updateOrCreate(
            ['flower_id' => $flowerId],
            ['period' => $period]
        );

        if (!$watering) {
            throw new ModelNotFoundException('Error while saving watering period', 404);
        }
    }
    

    public function FlowerWatering(Flower $flower): void
    {
        $watering = $flower->watering();

        if (!$watering->exists()) {
            throw new ModelNotFoundException('There is not set watering configs for this flower', 404);
        }
        
        $watering->update([
            'last_watering_date' => Carbon::now(),
            'next_watering_date' => Carbon::now()->addDay($watering->first()->period)
        ]);

        // Log a report of each watering
        $flower->wateringReport()->attach($watering->first()->id);
    }
}