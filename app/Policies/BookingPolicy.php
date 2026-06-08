<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return $booking->user_id !== null && (int) $booking->user_id === (int) $user->id;
    }

    public function delete(User $user, Booking $booking): bool
    {
        if ($user->is_admin) {
            return true;
        }

        if ($booking->user_id === null || (int) $booking->user_id !== (int) $user->id) {
            return false;
        }

        return in_array($booking->status, [Booking::STATUS_PENDING, Booking::STATUS_CONFIRMED], true);
    }
}
