<?php

namespace Tests\Feature;

use App\Mail\ReservationReminderMail;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Carbon\Carbon;

class ReservationReminderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_reservation_reminder_mail_is_sent_for_today_bookings()
    {
        Mail::fake();
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);
        $restaurant = Restaurant::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'book_at' => Carbon::today()->addHours(19),
            'headcount' => 2,
        ]);
        $this->artisan('reservation:remind');
        Mail::assertSent(ReservationReminderMail::class, function ($mail) use ($user, $booking, $restaurant) {
            return $mail->hasTo($user->email)
                && $mail->booking->id === $booking->id
                && $mail->booking->restaurant->name === $restaurant->name
                && Carbon::parse($mail->booking->book_at)->eq($booking->book_at);
        });
    }
}
