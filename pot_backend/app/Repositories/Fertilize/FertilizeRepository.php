<?php

namespace App\Repositories\Fertilize;

use App\Models\Fertilizer;
use App\Models\Flower;
use App\Models\FlowerFertilizer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FertilizeRepository implements FertilizeRepositoryInterface
{
    public function addPeriodAndAmountToFlowerFertilize(int $flowerId, int $fertilizeId, int $period, float $amount): void
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

    public function flowerFertalizing(Flower $flower): void
    {
        $fertiziling = $flower->flowerFertilizers();
        
        if (!$fertiziling->exists()) {
            throw new ModelNotFoundException('There is not set fertilizing configs for this flower', 404);
        }

        $fertiziling->update([
            'last_fertilizer_date' => Carbon::now(),
            'next_fertilizer_date' => Carbon::now()->addDay($fertiziling->first()->period),
        ]);

        // Log a report of each fertilizing
        $flower->fertazilingReport()->attach($fertiziling->first()->id);
    }


    public function create(string $name): void
    {
        Fertilizer::create([
            'name' => $name,
        ]);
    }

    public function getFertilizers(?int $paginationLimit)
    {
        return Fertilizer::paginate($paginationLimit ?? 12);
    }

    public function getUserTodoyFertilizing(User $user, ?int $paginationLimit)
    {
        $flowers = $user->flowers()->whereHas('flowerFertilizers', function($q) {
            $q->where('next_fertilizer_date', '<=', now());
        });

        return $flowers->paginate($paginationLimit ?? 12);
    }

    public function getTodoyFertilizing()
    {
        $flowers = Flower::with('users')->whereHas('flowerFertilizers', function($q) {
            $q->where('next_fertilizer_date', '<=', now());
        });

        return $flowers->get();   
    }
}