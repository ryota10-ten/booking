<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Restaurant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingUpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_user_can_view_and_update_booking()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();

        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'book_at' => Carbon::now()->addDays(1), // 未来日予約
            'headcount' => 2,
        ]);
        $this->actingAs($user, 'users');
        $response = $this->get(route('booking.detail', ['id' => $booking->id]));
        $response->assertStatus(200)
                ->assertSee($restaurant->name)
                ->assertSee($user->name);
        $response = $this->get(route('booking.edit', ['id' => $booking->id]));
        $response->assertStatus(200)
                ->assertSee('予約の変更');
        $newDate = Carbon::now()->addDays(2)->format('Y-m-d');
        $newTime = '19:00';
        $newHeadcount = 4;
        $response = $this->post(route('booking.change', ['id' => $booking->id]), [
            'date' => $newDate,
            'time' => $newTime,
            'headcount' => $newHeadcount,
        ]);
        $response->assertRedirect(route('booking.detail', ['id' => $booking->id]));
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'headcount' => $newHeadcount,
            'book_at' => Carbon::parse($newDate . ' ' . $newTime),
        ]);
    }

    public function test_booking_detail_page_displays_qrcode()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'users');
        $restaurant = Restaurant::factory()->create();
        $booking = Booking::factory()->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
            'book_at'       => Carbon::now()->addDays(2),
            'headcount'     => 2,
        ]);
        $response = $this->get(route('booking.detail', ['id' => $booking->id]));
        $response->assertStatus(200);
        $response->assertSee('<div class="qr">', false);
    }
}
