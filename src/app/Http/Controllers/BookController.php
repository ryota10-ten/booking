<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Mail\BookingReminderMail;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookController extends Controller
{
    public function show($id)
    {
        $booking = Booking::with('restaurant','user')->find($id);
        $url = route('booking.detail', ['id' => $booking->id]);
        $qr = QrCode::size(Booking::QR_CODE_SIZE)->generate($url);
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

    public function sendReminder($bookingId)
    {
        $booking = Booking::with('user', 'restaurant')->findOrFail($bookingId);

        Mail::to($booking->user->email)->send(new BookingReminderMail($booking));

        return back()->with('message', 'メールを送信しました');
    }
}
