<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Restaurant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $userCount = User::count();
        $restaurantCount = Restaurant::count();
        $HEADCOUNT_MIN = 1;
        $HEADCOUNT_MAX = 6;

        $DATE_OFFSETS = [
            -3,
            -1,
            -6/24,
            6/24,
            1,
            3,
        ];
        $data = [];

        foreach ($DATE_OFFSETS as $offset) {
            $date = Carbon::now()->addDays(floor($offset))
                                ->addHours(($offset - floor($offset)) * 24);
            $data[] = [
                'user_id' => rand(1, $userCount),
                'restaurant_id' => rand(1, $restaurantCount),
                'book_at' => $date,
                'headcount' => rand($HEADCOUNT_MIN, $HEADCOUNT_MAX),
            ];
        }

        foreach ($data as $booking) {
            Booking::create($booking);
        }
    }
}
