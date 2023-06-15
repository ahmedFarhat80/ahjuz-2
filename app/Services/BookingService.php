<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\SiteSetting;
use App\Enums\BookingStatus;
use Illuminate\Support\Facades\Session;

class BookingService
{
    public static $coupon;

    public static function getCalendarEvents($bookings)
    {
        $events = [];

        foreach ($bookings as $booking) {
            if ($booking->is_foreign) {
                $el = [
                    'title'     => 'مشغول',
                    'color'     => 'orange',
                    'details'   => $booking->details,
                    'delete_url'=> route('owner.properties.bookings.foreign.destroy', ['property' => $booking->property_id, 'booking' => $booking->id]),
                ]; 
            } else {
                $el = [
                    'title'             => $booking->status->is(BookingStatus::Paid) ? 'محجوز' : 'ملغي',
                    'color'             => $booking->status->is(BookingStatus::Paid) ? 'red' : 'grey',
                    'customer'          => $booking->customer->full_name ?? null,
                    'payment_method'    => $booking->payment_method->description,
                    'total_price'       => $booking->total_price,
                    'status'            => $booking->status->description,
                    'message'           => $booking->customer_id ? route('owner.messages.show', ['property' => $booking->property_id, 'customer' => $booking->customer_id]) : '',
                ];    
            }

            $events[] = $el + [
                'start'     => $booking->starts_at->format('Y-m-d'),
                'end'       => $booking->ends_at->format('Y-m-d'),
                'starts_at' => date_ar($booking->starts_at),
                'ends_at'   => date_ar($booking->ends_at),
            ];
        }
        
        return $events;
    }

    public static function checkCoupon(string $code) {
        $coupon = Coupon::valid($code)->first();
        return self::$coupon = $coupon;
    }

    public static function setCoupon() {
        Session::put('coupon', self::$coupon->code);
    }

    public static function totalPrice($subtotal) {
        return $subtotal - (self::$coupon ? self::$coupon->getDiscount($subtotal) : 0);
    }
    
    public static function forgetCoupon() {
        Session::forget('coupon');
    } 

    public static function setDates($starts_at, $ends_at) {
        return collect()->push((object)[
            'starts_at' => $starts_at, 
            'ends_at' => $ends_at, 
            'days' => dayDiff($starts_at, $ends_at),
        ])->first();
    }

    public static function getCommission($subtotal, $discount) {
        $commission =  SiteSetting::first()->commission;
        return  ($subtotal - $discount) * ($commission / 100);
    }
}
