<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Restaurant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'restaurant_id' => Restaurant::factory(),
            'book_at' => Carbon::now()->addDays($this->faker->numberBetween(1, 30)),
            'headcount' => $this->faker->numberBetween(1, 5),
        ];
    }
}
