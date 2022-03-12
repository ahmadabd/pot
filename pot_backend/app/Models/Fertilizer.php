<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fertilizer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function flowerFertilizers()
    {
        return $this->hasMany(FlowerFertilizer::class);
    }
}
