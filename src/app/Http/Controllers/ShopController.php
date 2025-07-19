<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Area;
use App\Models\Booking;
use App\Models\Genre;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function show($id)
    {
        $shop = Restaurant::with('area','genre')->find($id);
        return view ('detail',compact('shop'));
    }

    public function form(BookRequest $request)
    {
        $user = Auth::guard('users')->user();
        $bookAt = Carbon::parse($request->input('date') . ' ' . $request->input('time'));

        $new_booking = [
            'user_id' => $user->id,
            'restaurant_id' => $request->input('shop_id'),
            'headcount' => $request->input('headcount'),
            'book_at' => $bookAt,
        ];

        Booking::create($new_booking);

        return view('booking_done');
    }
}
