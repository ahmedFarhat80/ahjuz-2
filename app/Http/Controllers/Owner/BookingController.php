<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Notifications\BookingIsCanceledNotification;
use App\Notifications\BookingIsCreatedNotification;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct()
    {
        return $this->middleware('can:manage,property');
    }

    public function index(Property $property)
    {
        $events = BookingService::getCalendarEvents($property->bookings()->with('customer')->get());
        
        auth_owner()
            ->unreadNotifications
            ->whereIn('type', [BookingIsCreatedNotification::class, BookingIsCanceledNotification::class])
            ->where('data.property_id', $property->id)
            ->markAsRead();

        return view('owner.bookings', compact('property', 'events'));
    }

    public function foreign(Request $request, Property $property)
    {
        $validated = $request->validate([
            'starts_at' => 'required|date_format:Y/m/d|before:ends_at|after_or_equal:today',
            'ends_at' => 'required|date_format:Y/m/d',
            'details' => 'nullable',
        ]);

        if (!$property->isAvailable($validated['starts_at'], $validated['ends_at'])) {
            return back()->with(toastNotification('هذه الوحدة غير متوفرة', 'error'), 422);
        }

        $property->bookings()->create($validated + ['is_foreign' => 1]);

        return back()->with(toastNotification('الحجز', 'created'));
    }

    public function destroyForeign(Property $property, Booking $booking)
    {
        if (!$booking->is_foreign) {
            return response()->json(toastNotification('هذا الحجز لا يمكن إلغاءه', 'error'), 422);
        }

        $booking->delete();

        return route('owner.properties.bookings', $property->id);
    }
}
