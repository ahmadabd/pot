<?php

namespace App\Repositories\Flower;

use App\Models\Flower;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FlowerRepository implements FlowerRepositoryInterface 
{
    public function getFlower(User $user, int $id) 
    {
        return $user->flowers()
            ->where('flower_id', $id)
            ->getFlower()
            ->firstOrFail();
    }

    public function getFlowers(User $user, ?int $paginationLimit)
    {
        $flowers = $user->flowers()
            ->getFlower()
            ->paginate($paginationLimit ?? 12);
        
        return $flowers;
    }

    public function createFlower($request) 
    {
        DB::transaction(function() use($request) {
            $flower = Flower::create([
                'name' => $request->validated()['name'],
                'description' => $request->validated()['description'],
            ]);

            $flower->users()->attach($request->user, ['role_id' => Role::owner()->first()->id]);
        });
    }

    public function updateFlower($request, Flower $flower)
    {
        $flower->updateOrFail([
            'name' => $request->validated()['name'],
            'description' => $request->validated()['description']
        ]);
    }


    public function deleteFlower(Flower $flower)
    {
        $flower->delete();
    }
}