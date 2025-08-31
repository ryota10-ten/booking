<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Booking;
use App\Models\Genre;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\StripeService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\Checkout\Session as StripeSession;
use Tests\TestCase;

class DetailPageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private function createStripeSessionMock(): StripeSession
    {
        $mock = $this->getMockBuilder(StripeSession::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->id = 'sess_12345';
        $mock->url = 'https://stripe.test/session';

        return $mock;
    }

    public function test_shop_list_show()
    {
        $area = Area::factory()->create(['area' => '東京都']);
        $genre = Genre::factory()->create(['genre' => '寿司']);
        $shop = Restaurant::factory()->create([
            'name' => '銀座寿司',
            'detail' => '高級寿司店です。',
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'img_url' => 'test.jpg',
        ]);
        $response = $this->get(route('shop.detail', $shop->id));
        $response->assertStatus(200);
        $response->assertSee('銀座寿司');
        $response->assertSee('高級寿司店です。');
        $response->assertSee('東京都');
        $response->assertSee('寿司');
    }

    public function test_booking_form_success()
    {
        $user = User::factory()->create();
        $shop = Restaurant::factory()->create();

        $stripeServiceMock = $this->createMock(StripeService::class);
        $stripeServiceMock->method('createSession')
            ->willReturn($this->createStripeSessionMock());
        $this->app->instance(StripeService::class, $stripeServiceMock);

        $validData = [
            'shop_id' => $shop->id,
            'date' => Carbon::tomorrow()->format('Y-m-d'),
            'time' => '18:00',
            'headcount' => 2,
        ];

        $response = $this->actingAs($user, 'users')
            ->post(route('booking.store'), $validData);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'restaurant_id' => $shop->id,
            'headcount' => 2,
        ]);

        $response->assertRedirect();
    }

    public function test_booking_form_validation_error()
    {
        $user = User::factory()->create();
        $shop = Restaurant::factory()->create();

        $invalidData = [
            'shop_id' => $shop->id,
            'date' => Carbon::yesterday()->format('Y-m-d'),
            'time' => '12:00',
            'headcount' => 0,
        ];

        $response = $this->actingAs($user, 'users')
            ->post(route('booking.store'), $invalidData);

        $response->assertSessionHasErrors(['date', 'headcount']);
    }
}
