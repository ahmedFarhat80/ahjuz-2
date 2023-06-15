<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Coupon;
use App\Models\Property;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use App\Services\BookeeyService;
use App\Services\BookingService;
use App\Services\PaymentService;
use BenSampo\Enum\Rules\EnumKey;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\returnSelf;

class PaymentController extends Controller
{
    private $bookeeyService;

    public function __construct(BookeeyService $bookeeyService)
    {
        $this->bookeeyService = $bookeeyService;
    }

    public function index(Request $request, Property $property)
    {
        $request->validate([
            'starts_at' => 'required|before:ends_at|after_or_equal:today',
            'ends_at'   => 'required',
            'coupon'    => 'nullable|string',
        ]);

        $date = BookingService::setDates($request->starts_at, $request->ends_at);

        if (!$property->isAvailable($date->starts_at, $date->ends_at)) {
            return response()->json(['message' => 'هذه الوحدة غير متوفرة'], 404); 
        }

        $coupon = [];
        if ($v = $request->coupon) {
            $coupon = Coupon::valid($v)->first();
            if (!$coupon) {
                return response()->json(['message' => 'هذا الكوبون غير صالح'], 422); 
            }
        } 

        $payment_amount = $property->getTotalPrice($property->averagePrice, $date->days, $coupon);
        $payment_methods = PaymentMethod::getKeys();

        return response()->json(compact('payment_amount', 'payment_methods', 'property'), 422); 
    }

    public function charge(Request $request, Property $property)
    {
        $request->validate([
            'payment_method'    => ['required', new EnumKey(PaymentMethod::class)],
            'terms'             => 'accepted',
            'starts_at'         => 'required|before:ends_at|after_or_equal:today',
            'ends_at'           => 'required',
            'coupon'            => 'nullable|string',
        ]);

        $date = BookingService::setDates($request->starts_at, $request->ends_at);

        $coupon = [];
        if ($v = $request->coupon) {
            $coupon = Coupon::valid($v)->first();
            if (!$coupon) {
                return response()->json(['message' => 'هذا الكوبون غير صالح'], 422); 
            }
        } 
        
        $data = [
            'fail_url'          => url()->previous(),
            'success_url'       => redirect(route('api.v1.properties.payment.success', ['property' => $property->id, 'data' => $date->starts_at . '*' . $date->ends_at . '*' . $request->coupon]))->header('Authorization', 'Bearer '.$request->bearerToken())->header('Accept', 'application/json'),
            'payment'           => $property->getTotalPrice($property->averagePrice, $date->days, $coupon),
            'payment_method'    => $request->payment_method,
            'email'             => $request->user()->email,
            'phone'             => country_code($request->user()->phone),
        ];

        $response = $this->bookeeyService->loadRequest($data)->sendPayment();

        return $response['PayUrl'] 
                ? response()->json(['PayUrl' => $response['PayUrl']], 200) 
                : response()->json(['message' => 'حدث خطأ ما'], 422);
    }

    public function success(Request $request, Property $property)
    {
        $response = $this->bookeeyService->getStatus($request->merchantTxnId);
        $finalStatus = $response['PaymentStatus']['0']['finalStatus'];
        [$starts_at, $ends_at, $coupon] = explode('*', $request->data);

        $date = BookingService::setDates($starts_at, $ends_at);

        if ($coupon) {
            $coupon = Coupon::valid($coupon)->first();
            if (!$coupon) {
                return response()->json(['message' => 'هذا الكوبون غير صالح'], 422); 
            }
        } 
        
        if (!$property->isAvailable($date->starts_at, $date->ends_at)) {
            return response()->json(['message' => 'هذه الوحدة غير متوفرة'], 404); 
        }

        if ($finalStatus == 'success') {
            $booking = PaymentService::charge($response, $date, $coupon, $property, $request->user()->id);
            return response()->json(['message' => 'تم إنشاء الحجز بنجاح', 'booking' => $booking], 200); 
        }
    }
}