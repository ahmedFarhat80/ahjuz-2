<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Property;
use App\Enums\BookingStatus;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function review(Customer $customer, Booking $booking)
    {
        return $customer->id == $booking->customer_id && $booking->starts_at->lessThanOrEqualTo(today()) && $booking->status->is(BookingStatus::Paid);
    }

    public function cancel(Admin $admin, Booking $booking)
    {
        return $booking->ends_at->greaterThan(today()) && $booking->status->is(BookingStatus::Paid);
    }
}
