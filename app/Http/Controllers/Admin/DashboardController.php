<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Models\Admin;
use App\Models\Owner;
use App\Models\Coupon;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;

class DashboardController extends Controller
{
    public function index()
    {
        $adm_count    = Admin::count();
        $own_count    = Owner::count();
        $cus_count    = Customer::count();
        $pro_count    = Property::count();
        $boo_count    = Booking::count();
        $cou_count    = Coupon::count();

        $stats = [
            'عدد المشرفين' => $adm_count,
            'عدد الملاك' => $own_count,
            'عدد الزبائن' => $cus_count,
            'عدد الوحدات' => $pro_count,
            'عدد الحجوزات' => $boo_count,
            'عدد الكوبونات' => $cou_count,
        ];

        $bookings = Booking::with('property', 'customer')->notForeign()->latest()->limit(10)->get();

        $settings = SiteSetting::first();

        $sales = [
            [
                'name' => 'مبيعات هذا اليوم', 
                'value' => Booking::selectRaw('IFNULL(SUM(subtotal_price), 0) - IFNULL(SUM(discount), 0) as sale')->whereToday()->where('status', BookingStatus::Paid)->value('sale'), 
            ],
            [
                'name' => 'مبيعات هذا الشهر', 
                'value' => Booking::selectRaw('IFNULL(SUM(subtotal_price), 0) - IFNULL(SUM(discount), 0) as sale')->thisMonth()->where('status', BookingStatus::Paid)->value('sale'), 
            ],
            [
                'name' => 'إجمالي المبيعات', 
                'value' => Booking::selectRaw('IFNULL(SUM(subtotal_price), 0) - IFNULL(SUM(discount), 0) as sale')->where('status', BookingStatus::Paid)->value('sale'), 
            ],
        ];

        return view('admin.dashboard.index', compact('stats', 'bookings', 'settings', 'sales'));
    }
}