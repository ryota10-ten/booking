<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Manager;
use App\Models\Restaurant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagerMypageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_manager_mypage()
    {
        $manager = Manager::factory()->create([
            'password' => bcrypt('testpass'),
        ]);
        $restaurant = Restaurant::factory()->create([
            'manager_id' => $manager->id,
        ]);
        $otherRestaurant = Restaurant::factory()->create();
        $user = User::factory()->create();
        $bookingForOwnRestaurant = Booking::factory()->create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'book_at' => Carbon::now()->addDays(1),
            'headcount' => 2,
        ]);
        $bookingForOtherRestaurant = Booking::factory()->create([
            'user_id' => $user->id,
            'restaurant_id' => $otherRestaurant->id,
            'book_at' => Carbon::now()->addDays(1),
            'headcount' => 3,
        ]);
        $response = $this->post(route('manager_login'), [
            'email' => $manager->email,
            'password' => 'testpass',
        ]);
        $response->assertRedirect(route('manager_page.show'));
        $response = $this->get(route('manager_page.show'));
        $response->assertStatus(200);
        $response->assertSee($bookingForOwnRestaurant->user->name);
        $response->assertSee($restaurant->name);
        $response->assertDontSee($otherRestaurant->name);
    }
}
