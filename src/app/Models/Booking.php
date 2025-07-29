<?php

namespace App\Models;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'book_at',
        'headcount',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

}
