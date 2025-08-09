<?php

namespace App\Console\Commands;

use App\Mail\ReservationReminderMail;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '予約当日の朝にリマインドメールを送る';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();
        // 本番
        $bookings = Booking::with('user', 'restaurant')
            ->whereDate('book_at', $today)
            ->get();
        // // テスト
        // $bookings = Booking::with('user', 'restaurant')->get();
        foreach ($bookings as $booking) {
            Mail::to($booking->user->email)->send(new ReservationReminderMail($booking));
        }
    }
}
