<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
    ];
    
    public function scopeOwner($query)
    {
        return $query->where('role', 'owner');
    }


    public function scopeAssistant($query)
    {
        return $query->where('role', 'assistant');
    }
}
