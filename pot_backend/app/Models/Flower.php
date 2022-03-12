<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'flower_users')->withPivot('role_id');
    }

    public function owner()
    {
        return $this->users()->wherePivot('role_id', Role::owner()->first()->id);
    }

    public function watering()
    {
        return $this->hasOne(Watering::class);
    }

    public function flowerFertilizers()
    {
        return $this->hasMany(FlowerFertilizer::class);
    }
}
