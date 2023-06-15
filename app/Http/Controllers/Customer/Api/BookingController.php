<?php

namespace App\Http\Controllers\Customer\Api;

use Illuminate\Http\Request;
use App\Services\BookingService;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;

class BookingController extends Controller
{
    public function coupon(Request $request) {

        $subtotal = $request->subtotal;
        $insurance = $request->insurance;
        $code = $request->code;
        $coupon = null;
        

        if ($code) {
            $coupon = BookingService::checkCoupon($code);
        }

        if (!$coupon) {
            return response()->json(['message' => 'هذا الكوبون غير صالح'], 404);
        }

        BookingService::setCoupon();
        
        return response()->json([
            'coupon'    => new CouponResource($coupon),
            'total'     =>  BookingService::totalPrice($subtotal) + $insurance,
            'discount'  => $coupon->getDiscount($subtotal),
        ]);
    }
}
