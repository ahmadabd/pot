<?php

namespace App\Policies;

use App\Models\Flower;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FlowerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // who can make changes on data
    public function change(User $user, Flower $flower)
    {
        return $user->id == $flower->owner()->first()->id;
    }

    // who can just read data
    // public function access(User $user, Flower $flower)
    // {
    //     return $user->id == $flower->users()->first()->id;
    // }
}
