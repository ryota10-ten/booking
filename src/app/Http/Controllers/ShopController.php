<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Booking;
use App\Models\Restaurant;
use App\Services\StripeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    protected $stripeService;
    
    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

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
        $booking->load('restaurant');

        $session = $this->stripeService->createSession($booking);
        $booking->update(['stripe_session_id' => $session->id]);

        return redirect()->to($session->url);
    }
}
