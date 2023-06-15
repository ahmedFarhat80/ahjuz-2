<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\DataTables\CouponDataTable;
use App\Enums\CouponStatus;
use App\Enums\CouponType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;

class CouponController extends Controller
{
    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('admin.coupons.table.index', ['types' => CouponType::asSelectArray()]);
    }

    public function store(StoreCouponRequest $request)
    {
        return Coupon::create($request->validated());
    }
    
    public function show(Coupon $coupon)
    {
        return view('admin.coupons.details.index', [
            'coupon'    => $coupon,
            'types'     => CouponType::asSelectArray(),
        ]);
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->validated());
        return redirect()->route('admin.coupons.index')->with(toastNotification('الكوبون', 'updated'));
    }

    public function destroy(Request $request, Coupon $coupon)
    {
        if ($request->expectsJson()) {
            $coupon->delete();
            return route('admin.coupons.index');    
        } 
    }

}
