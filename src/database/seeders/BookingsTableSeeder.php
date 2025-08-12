<?php

namespace Database\Seeders;

use App\Models\Booking;
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
        $dates = [
            Carbon::now()->subDays(3),
            Carbon::now()->subDays(1),
            Carbon::now()->subHours(6),
            Carbon::now()->addHours(6),
            Carbon::now()->addDays(1),
            Carbon::now()->addDays(3),
        ];

        foreach ($dates as $date) {
            $data[] = [
                'user_id' => rand(1, 2),
                'restaurant_id' => rand(1, 5),
                'book_at' => $date,
                'headcount' => rand(1, 6),
            ];
        }

        foreach ($data as $booking) {
            Booking::create($booking);
        }
    }
}
