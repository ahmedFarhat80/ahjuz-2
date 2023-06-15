<?php

namespace App\Http\Controllers\Customer;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Services\BookingService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{

    public function date(Request $request, Property $property)
    {
        $validated = $request->validate([
            'starts_at' => 'required|date_format:Y/m/d|before:ends_at|after_or_equal:today',
            'ends_at' => 'required|date_format:Y/m/d',
            'details' => 'nullable',
        ]);
        
        Session::put('date', BookingService::setDates($validated['starts_at'], $validated['ends_at']));

        return back();
    }

    public function coupon(Request $request) {

        $subtotal = $request->subtotal;
        $insurance = $request->insurance;
        $code = $request->code;
        $coupon = null;
        
        BookingService::forgetCoupon();

        if ($code) {
            $coupon = BookingService::checkCoupon($code);
        }

        if (!$coupon) {
            return response()->json([
                'error' => 'هذا الكوبون غير صالح',
                'total' =>  $subtotal + $insurance,
            ]);
        }

        BookingService::setCoupon();
        
        return response()->json([
            'coupon'    => $coupon->only(['id', 'code', 'value']),
            'total'     =>  BookingService::totalPrice($subtotal) + $insurance,
            'discount'  => $coupon->getDiscount($subtotal),
        ]);
    }

    public function destroyCoupon(Request $request) {
        BookingService::forgetCoupon();
        return response()->json(['total' =>  $request->subtotal + $request->insurance]);
    }
}