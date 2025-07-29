<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookController extends Controller
{
    public function show($id)
    {
        $booking = Booking::with('restaurant','user')->find($id);
        $url = route('booking.detail', ['id' => $booking->id]);
        $qr = QrCode::size(200)->generate($url);
        return view ('booking_confirm',compact('booking', 'qr'));
    }

    public function edit($id)
    {
        $booking = Booking::with('restaurant','user')->find($id);
        return view ('booking_edit',compact('booking'));
    }

    public function change(BookRequest $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $date = $request->input('date');
        $time = $request->input('time');
        $datetime = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $time);

        $booking->book_at = $datetime;
        $booking->headcount = $request->input('headcount');
        $booking->save();

        return redirect()->route('booking.detail', ['id' => $booking->id]);
    }
}
