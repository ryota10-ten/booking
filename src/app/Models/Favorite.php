<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $primaryKey = ['user_id', 'restaurant_id'];

    protected $fillable = [
        'user_id',
        'restaurant_id',
    ];
}
