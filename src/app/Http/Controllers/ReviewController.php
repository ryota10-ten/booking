<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($id)
    {
        $minReview_count = config('constants.min_review_count');
        $maxReview_count = config('constants.max_review_count');
        $booking = Booking::with('restaurant','user')->find($id);
        return view('review',compact('minReview_count', 'maxReview_count','booking'));
    }

    public function review(Request $request, $id)
    {
        Review::create([
            'user_id' => $request->input('user_id'),
            'restaurant_id' => $id,
            'review' => $request->input('review'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('user.mypage',);
    }
}
