<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MyBooking;
use Carbon\Carbon;

class AutoCancelOldBookings extends Command
{
    protected $signature = 'bookings:auto-cancel';
    protected $description = 'Automatically cancel bookings pending for more than 1 hour';

    public function handle()
    {
        $expiredBookings = MyBooking::where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subHour())
            ->get();

        foreach ($expiredBookings as $booking) {
            $booking->status = 'cancelled';
            $booking->save();
            $this->info("Cancelled booking: " . $booking->booking_reference);
        }

        $this->info('Expired bookings processed.');
    }
}
