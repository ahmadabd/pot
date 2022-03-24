<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watering extends Model
{
    use HasFactory;

    protected $fillable = [
        'flower_id',
        'period',
        'last_watering_date',
        'next_watering_date',
    ];
}
