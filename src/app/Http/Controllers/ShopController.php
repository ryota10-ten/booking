<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Booking;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
    public function show($id)
    {
        $shop = Restaurant::with('area','genre')->find($id);
        $minHeadcount = config('constants.min_headcount');
        $maxHeadcount = config('constants.max_headcount');
        return view ('detail',compact('shop','minHeadcount', 'maxHeadcount'));
    }

    public function form(BookRequest $request)
    {
        $user = Auth::guard('users')->user();
        $bookAt = Carbon::parse($request->input('date') . ' ' . $request->input('time'));

        $booking = Booking::create([
            'user_id' => $user->id,
            'restaurant_id' => $request->input('shop_id'),
            'headcount' => $request->input('headcount'),
            'book_at' => $bookAt,
        ]);
        $reservationFee = Booking::RESERVATION_FEE;
        Stripe::setApiKey(config('services.stripe.secret'));
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
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('booking.done', ['id' => $booking->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('shop.detail', ['id' => $booking->restaurant_id]),
            'metadata' => [
                'booking_id' => $booking->id,
                'user_id' => $user->id,
            ],
        ]);
        $booking->update(['stripe_session_id' => $session->id]);

        return redirect($session->url);
    }
}
