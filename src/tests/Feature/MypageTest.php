<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Restaurant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MypageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_mypage_show()
    {
        $user = User::factory()->create([
            'name' => 'テスト太郎',
        ]);
        $this->actingAs($user, 'users');
        $response = $this->get(route('user.mypage'));
        $response->assertStatus(200);
        $response->assertSee('テスト太郎');
    }

    public function mypage_displays_user_name_booking_and_favorites()
    {
        $user = User::factory()->create([
            'name' => 'テスト太郎',
        ]);
        $this->actingAs($user, 'users');
        $restaurant = Restaurant::factory()->create([
            'name' => 'テストレストラン',
        ]);
        $booking = Booking::factory()->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
            'book_at'       => Carbon::now()->addDays(1),
            'headcount'     => 2,
        ]);
        $user->favorites()->attach($restaurant->id);
        $response = $this->get(route('user.mypage'));
        $response->assertStatus(200);
        $response->assertSee('テスト太郎');
        $response->assertSee('テストレストラン');
        $response->assertSee('2人');
        $response->assertSee('テストレストラン');
    }

    public function user_can_delete_booking_from_mypage()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'users');
        $restaurant = Restaurant::factory()->create();
        $booking = Booking::factory()->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
            'book_at'       => Carbon::now()->addDays(1),
            'headcount'     => 3,
        ]);
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
        ]);
        $response = $this->delete(route('booking.destroy'), [
            'booking_id' => $booking->id,
        ]);
        $response->assertRedirect();
        $this->assertDatabaseMissing('bookings', [
            'id' => $booking->id,
        ]);
    }

    public function mypage_displays_edit_button_for_future_booking()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'users');

        $restaurant = Restaurant::factory()->create();
        $futureBooking = Booking::factory()->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
            'book_at'       => Carbon::now()->addDays(3),
            'headcount'     => 2,
        ]);
        $response = $this->get(route('user.mypage'));

        $response->assertStatus(200);
        $response->assertSee('予約の変更・詳細 >');
        $response->assertDontSee('レビューを投稿 >');
    }

    public function mypage_displays_review_button_for_past_booking()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'users');

        $restaurant = Restaurant::factory()->create();
        $pastBooking = Booking::factory()->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
            'book_at'       => Carbon::now()->subDays(3),
            'headcount'     => 2,
        ]);
        $response = $this->get(route('user.mypage'));

        $response->assertStatus(200);
        $response->assertSee('レビューを投稿 >');
        $response->assertDontSee('予約の変更・詳細 >');
    }
}
