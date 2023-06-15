<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Notifications\BookingIsCanceledNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit() 
    {
        return view('customer.profile');
    }

    public function update(UpdateCustomerRequest $request)
    {
        $customer = Customer::findOrFail(auth_customer()->id);

        $attributes = $request->validated();
        
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete($customer->getRawOriginal('avatar'));
            $attributes['avatar'] = img_upload($request->file('avatar'), Customer::AVATARS_STOREAGE, true);
        }

        $customer->update($attributes);

        return redirect()->route('profile')->with(toastNotification('حسابك', 'updated'));
    }

    public function bookings()
    {
        auth_customer()->unreadNotifications->where('type', BookingIsCanceledNotification::class)->markAsRead();

        return view('customer.my-bookings', 
            [
                'reviews' => auth_customer()->load([
                    'bookings' => fn($q) => $q->latest(),
                    'bookings.property',
                    'bookings.property.address',
                    'bookings.property.imgs',
                    'bookings.property.reviews' => fn($q) => $q->where('customer_id', auth_customer()->id)
                ])->bookings->map(fn($v) => optional($v->property)->reviews)->collapse()
            ]
        );
    }
}
