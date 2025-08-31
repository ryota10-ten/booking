<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MyPageController extends Controller
{
    public function show()
    {
        $user = Auth::guard('users')->user();
        $shops = $user->favorites()
            ->with(['area', 'genre'])
            ->get();
        $bookings = $user->bookings()
            ->with('restaurant')
            ->orderBy('book_at', 'desc')
            ->get();

        return view('user.mypage',compact('shops','user','bookings'));
    }

    public function destroy(Request $request)
    {
        $booking = Booking::find($request->input('booking_id'));
        $booking->delete();
        return redirect()->back();
    }
}
