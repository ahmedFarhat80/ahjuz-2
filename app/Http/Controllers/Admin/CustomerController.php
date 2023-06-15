<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\CustomersDataTable;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    public function index(CustomersDataTable $dataTable)
    {
        return $dataTable->render('admin.customers.table.index');
    }

    public function store(StoreCustomerRequest $request)
    {
        return Customer::create($request->validated());
    }
    
    public function show(Customer $customer)
    {
        $customer->loadSum(['bookings' => fn($q) => $q->where('bookings.status', BookingStatus::Paid)], 'subtotal_price');
        $customer->loadSum(['bookings' => fn($q) => $q->where('bookings.status', BookingStatus::Paid)], 'discount');
        $bookings = $customer->bookings()->with('property')->paginate(5);
        return view('admin.customers.details.index', compact('customer', 'bookings'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $attributes = $request->validated();
    
        if ($request->avatar_remove || $request->hasFile('avatar')) {
            Storage::disk('public')->delete($customer->getRawOriginal('avatar'));
            $attributes['avatar'] = null;
        }

        if ($request->hasFile('avatar')) {
            $attributes['avatar'] = img_upload($request->file('avatar'), Customer::AVATARS_STOREAGE, true);
        }
    
        return $customer->update($attributes);
    }

    public function destroy(Request $request, Customer $customer)
    {
        if ($request->expectsJson()) {
            Storage::disk('public')->delete($customer->getRawOriginal('avatar'));
            $customer->delete();
            return route('admin.customers.index');    
        } 
    }
}
