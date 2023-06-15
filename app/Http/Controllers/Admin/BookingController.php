<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\BookingsDataTable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BookingIsCanceledNotification;
use App\Services\FirebaseService;

class BookingController extends Controller
{
    public function index(BookingsDataTable $dataTable)
    {
        return $dataTable->render('admin.bookings.table.index');
    }

    public function show(Booking $booking)
    {
        abort_if($booking->is_foreign, 403);
        return view('admin.bookings.details.index', compact('booking'));
    }

    public function cancel(Request $request, Booking $booking)
    {
        $this->authorize('cancel', $booking);
        
        if ($request->expectsJson()) {

            $booking->update(['status' => BookingStatus::Canceled]);
            
            Notification::send([$booking->customer, $booking->property->owner], new BookingIsCanceledNotification($booking->property));
            
            if ($token = $booking->customer->fcm_token) {
                FirebaseService::sendNotification($token, 'تم إلغاء حجز لديك');
            }

            return route('admin.bookings.index');
        }
    }

}
