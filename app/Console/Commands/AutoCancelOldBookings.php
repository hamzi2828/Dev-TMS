<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MyBooking;
use Carbon\Carbon;

class AutoCancelOldBookings extends Command
{
    protected $signature = 'bookings:auto-cancel';
    protected $description = 'Automatically cancel bookings where airline group expire_datetime has passed';

    public function handle()
    {
        // Get bookings with status 'pending' where airlineGroup expire_datetime is in the past
        $expiredBookings = MyBooking::where('status', 'pending')
            ->whereHas('airlineGroup', function ($query) {
                $query->where('expire_datetime', '<=', Carbon::now());
            })
            ->get();

        foreach ($expiredBookings as $booking) {
            $booking->status = 'cancelled';
            $booking->save();

            $this->info("Cancelled booking: " . $booking->booking_reference);

            $airlineGroup = $booking->airlineGroup;
            if ($airlineGroup) {
                $totalSeats = $booking->adults + $booking->children;
                $airlineGroup->used_seats = max(0, $airlineGroup->used_seats - $totalSeats);
                $airlineGroup->save();
            }
        }

        $this->info('Expired bookings processed.');
    }
}
