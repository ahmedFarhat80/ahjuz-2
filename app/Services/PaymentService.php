<?php

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Services\BookingService;
use Illuminate\Support\Facades\DB;
use App\Notifications\BookingIsCreatedNotification;

class PaymentService {

    public static function charge($response, $date, $coupon, $property, $customer_id)
    {
        DB::transaction(function () use ($response, $date, $coupon, $property, $customer_id) {

            $PaymentType    = $response['PaymentStatus']['0']['PaymentType'];
            $payment_method = $PaymentType == 'CCRD' ? PaymentMethod::Credit : PaymentMethod::Knet;    
            $subtotal       = $property->averagePrice * $date->days;
            $total_price    = $property->getTotalPrice($property->averagePrice, $date->days, $coupon);
            $discount       = $coupon ? $coupon->getDiscount($subtotal) : null;
            $commission     = BookingService::getCommission($subtotal, $discount);

            $booking = $property->bookings()->create([
                'customer_id'       => $customer_id,
                'coupon_id'         => $coupon ? $coupon->id : null,
                'payment_method'    => $payment_method,

                'subtotal_price'    => $subtotal,
                'insurance'         => $property->insurance_price,
                'discount'          => $coupon ? $coupon->getDiscount($subtotal) : null,
                'total_price'       => $total_price,
                'commission'        => $commission,
                'revenue'           => $total_price - $commission,

                'starts_at'         => $date->starts_at,
                'ends_at'           => $date->ends_at,
            ]);

            if ($coupon) {
                $coupon->increment('use_count', 1);
            }

            $property->owner->notify(new BookingIsCreatedNotification($property));

            return $booking;
        });
    }
}
