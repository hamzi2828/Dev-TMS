<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MyBooking;
use App\Models\AirlineGroup;
use Carbon\Carbon;

class AutoCancelOldBookings extends Command
{
    protected $signature = 'bookings:auto-cancel';
    protected $description = 'Automatically cancel bookings pending for more than 1 hour';

    public function handle()
    {
        $expiredBookings = MyBooking::where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subMinutes(60))
            ->get();


        foreach ($expiredBookings as $booking) {
            $booking->status = 'cancelled';
            $booking->save();
            $this->info("Cancelled booking: " . $booking->booking_reference);
            $airlineGroup = AirlineGroup::find($booking->airline_group_id);
            $totalSeats = $booking->adults + $booking->children;
            $airlineGroup->used_seats = $airlineGroup->used_seats - $totalSeats;
            $airlineGroup->save();
        }

        $this->info('Expired bookings processed.');
    }
}
