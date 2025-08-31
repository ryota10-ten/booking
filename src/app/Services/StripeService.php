<?php

namespace App\Services;

use App\Models\Booking;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService
{
    public function createSession(Booking $booking): Session
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $reservationFee = Booking::RESERVATION_FEE;

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $booking->restaurant->name . ' 予約金',
                    ],
                    'unit_amount' => $reservationFee,
                ],
                'quantity' => Booking::QUANTITY,
            ]],
            'mode' => 'payment',
            'success_url' => route('booking.done', ['id' => $booking->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('shop.detail', ['id' => $booking->restaurant_id]),
            'metadata' => [
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
            ],
        ]);

        return $session;
    }
}
