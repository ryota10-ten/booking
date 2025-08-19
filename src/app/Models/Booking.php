<?php

namespace App\Models;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'headcount',
        'book_at',
        'stripe_session_id',
        'stripe_payment_intent_id',
    ];

    public const QR_CODE_SIZE = 200;
    public const RESERVATION_FEE = 500;

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
