<?php

namespace App\Policies;

use App\Models\User;

class MyBookingPolicy
{
    public function myBooking(User $user): bool {
        return in_array('myBooking', $user->permissions());
    }

    public function bookTickets(User $user): bool {
        return in_array('book-tickets', $user->permissions());
    }

    public function bookNowBookTickets(User $user): bool {
        return in_array('book-now-book-tickets', $user->permissions());
    }

    public function pendingBooking(User $user): bool {
        return in_array('pending-booking', $user->permissions());
    }

    public function confirmBookingPendingBooking(User $user): bool {
        return in_array('confirm-booking-pending-booking', $user->permissions());
    }

    public function cancelBookingPendingBooking(User $user): bool {
        return in_array('cancel-booking-pending-booking', $user->permissions());
    }

    public function editBookingPendingBooking(User $user): bool {
        return in_array('edit-booking-pending-booking', $user->permissions());
    }

    public function cancelledBooking(User $user): bool {
        return in_array('cancelled-booking', $user->permissions());
    }

    public function confirmedBooking(User $user): bool {
        return in_array('confirmed-booking', $user->permissions());
    }

    public function editConfirmedBooking(User $user): bool {
        return in_array('edit-confirmed-booking', $user->permissions());
    }

    public function cancelBookingConfirmedBooking(User $user): bool {
        return in_array('cancel-booking-confirmed-booking', $user->permissions());
    }

    public function printTicketConfirmedBooking(User $user): bool {
        return in_array('print-ticket-confirmed-booking', $user->permissions());
    }

    public function myLedger(User $user): bool {
        return in_array('my-ledger', $user->permissions());
    }
}
