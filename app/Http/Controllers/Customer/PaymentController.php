<?php

namespace App\Http\Controllers\Customer;

use App\Models\Coupon;
use App\Models\Property;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use BenSampo\Enum\Rules\EnumKey;
use App\Services\BookeeyService;
use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    private $bookeeyService;

    public function __construct(BookeeyService $bookeeyService)
    {
        $this->bookeeyService = $bookeeyService;
    }

    public function index(Property $property)
    {
        $date = Session::get('date');

        if (!$date) {
            return redirect()->route('properties.show', $property->slug);
        }

        if (!$property->isAvailable($date->starts_at, $date->ends_at)) {
            return redirect()->route('properties.show', $property->slug)->with(toastNotification('هذه الوحدة غير متوفرة', 'error'), 422);
        }

        $coupon = [];
        if ($v = Session::get('coupon')) {
            $coupon = Coupon::valid($v)->first();
            if (!$coupon) {
                return redirect()->route('properties.show', $property->slug)->with(toastNotification('هذا الكوبون غير صالح', 'error'));
            }
        } 

        $payment = $property->getTotalPrice($property->averagePrice, $date->days, $coupon);

        return view('customer.payment', compact('property', 'payment'));
    }

    public function charge(Request $request, Property $property)
    {
        $date = Session::get('date');
        if (!$date) {
            return redirect()->route('properties.show', $property->slug);
        }

        $request->validate([
            'payment_method'    => ['required', new EnumKey(PaymentMethod::class)],
            'terms'             => 'accepted',
        ]);

        $coupon = [];
        if ($v = Session::get('coupon')) {
            $coupon = Coupon::valid($v)->first();
            if (!$coupon) {
                return redirect()->route('properties.show', $property->slug)->with(toastNotification('هذا الكوبون غير صالح', 'error'));
            }
        } 
        
        $data = [
            'fail_url'          => url()->previous(),
            'success_url'       => route('properties.payment.success', $property->id),
            'payment'           => $property->getTotalPrice($property->averagePrice, $date->days, $coupon),
            'payment_method'    => $request->payment_method,
            'email'             => auth_customer()->email,
            'phone'             => country_code(auth_customer()->phone),
        ];

        $response = $this->bookeeyService->loadRequest($data)->sendPayment();

        return $response['PayUrl'] 
                ? redirect()->to($response['PayUrl']) 
                : redirect()->route('properties.show', $property->slug)->with(toastNotification('حدث خطأ ما', 'error'));
    }

    public function success(Request $request, Property $property)
    {
        $response = $this->bookeeyService->getStatus($request->merchantTxnId);
        $finalStatus = $response['PaymentStatus']['0']['finalStatus'];

        $date = Session::get('date');
        if (!$date) {
            return redirect()->route('properties.show', $property->slug);
        }

        $coupon = [];
        if ($v = Session::get('coupon')) {
            $coupon = Coupon::valid($v)->first();
            if (!$coupon) {
                return redirect()->route('properties.show', $property->slug)->with(toastNotification('هذا الكوبون غير صالح', 'error'));
            }
        } 
        
        if (!$property->isAvailable($date->starts_at, $date->ends_at)) {
            return redirect()->route('properties.show', $property->slug)->with(toastNotification('هذه الوحدة غير متوفرة', 'error'), 422);
        }

        if ($finalStatus == 'success') {

            PaymentService::charge($response, $date, $coupon, $property, auth_customer()->id);

            Session::forget('date');
            Session::forget('coupon');
            Session::save();
    
            return redirect()->route('home')->with(toastNotification('الحجز', 'created'));    
        }
    }
}
      
