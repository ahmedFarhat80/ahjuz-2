<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\BookingResource;

class ProfileController extends Controller
{
    public function show(Request $request) 
    {
        return $request->user();
    }

    public function update(UpdateCustomerRequest $request)
    {
        $attributes = $request->validated();
        
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete($request->user()->getRawOriginal('avatar'));
            $attributes['avatar'] = img_upload($request->file('avatar'), Customer::AVATARS_STOREAGE, true);
        }

        $request->user()->update($attributes);

        return response()->json(['message' => 'تم تحديث حسابك بنجاح'], 200); 
    }

    public function bookings(Request $request)
    {
        $request->user()->unreadNotifications->where('type', BookingIsCanceledNotification::class)->markAsRead();

        $request->user()->load([
            'bookings' => fn($q) => $q->latest(),
            'bookings.property',
            'bookings.property.address',
            'bookings.property.imgs',
            'bookings.property.reviews' => fn($q) => $q->where('customer_id', $request->user()->id)
        ]);

        return BookingResource::collection($request->user()->bookings); 
    }

    public function fcm_token(Request $request)
    {
        $attributes = $request->validate(['fcm_token' => 'required']);
        $request->user()->update($attributes);
        return response()->json(['message' => 'تم التحديث بنجاح'], 200); 
    }
}
