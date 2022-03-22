<?php

namespace App\Http\Controllers;

use App\Http\Requests\WateringRequest;
use App\Models\Flower;

class WateringController extends Controller
{
    public function addWateringToFlower(WateringRequest $request, Flower $flower)
    {
        dd($flower);
    }
}
