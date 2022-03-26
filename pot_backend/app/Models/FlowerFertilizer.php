<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlowerFertilizer extends Model
{
    use HasFactory;

    protected $fillable = [
        'fertilizer_id',
        'flower_id',
        'period',
        'amount',
    ];

    public function fertilizers()
    {
        return $this->belongsTo(Fertilizer::class, 'fertilizer_id');
    }
}
