<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_user_can_post_review_for_past_booking()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'users');
        $restaurant = Restaurant::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'book_at' => Carbon::now()->subDays(5),
            'headcount' => 2,
        ]);
        $response = $this->get(route('restaurant.review', ['id' => $booking->id]));
        $response->assertStatus(200);
        $response->assertSee($restaurant->name);
        $reviewData = [
            'user_id' => $user->id,
            'review' => 4,
            'comment' => '美味しくて雰囲気も良かったです！',
        ];
        $response = $this->post(route('form.review', ['id' => $restaurant->id]), $reviewData);
        $response->assertRedirect(route('user.mypage'));
        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'review' => 4,
            'comment' => '美味しくて雰囲気も良かったです！',
        ]);
    }
}
