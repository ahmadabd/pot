<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlowerUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flower_id',
        'role_id'
    ];
}
