<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use App\Models\Property;
use App\Models\Governorate;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use Jorenvh\Share\ShareFacade;
use App\Services\BookingService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PropertyController extends Controller
{
    // public function index()
    // {
    //     return view('customer.properties.index', [
    //         'properties' => Property::with(['address', 'imgs'])->withCount('reviews')->withAvg('reviews', 'rating')->paginate(3)
    //     ]);
    // }

    public function show(Request $request, Property $property)
    {

        if ($request->expectsJson()) {
            $newReviews = $property->reviews()->with('customer')->latest()->paginate(5);
            $pagination = $newReviews->appends(request()->except('page'))->links()->render();
            $reviews = view('customer.property.reviews', ['reviews' => $newReviews])->render();
            return response()->json(compact('reviews', 'pagination', 'newReviews'));    
        } 

        abort_unless($property->canBeShown, 403);

        $property->loadAvg('reviews', 'rating');
        $reviews = $property->reviews()->with('customer')->latest()->paginate(5);

        if (!Session::get('date')) {
            Session::put('date', BookingService::setDates(today()->format('Y/m/d'), today()->addDay()->format('Y/m/d')));
        }

        $date = Session::get('date');
        $isAvailable = $property->isAvailable($date->starts_at, $date->ends_at);

        BookingService::forgetCoupon();

        $shareComponent = ShareFacade::page(route('properties.show', $property->slug),'')
        ->facebook()
        ->twitter()
        ->telegram()
        ->whatsapp();      

        views($property)->cooldown(24*60)->record();

        return view('customer.property.index', compact('property', 'date', 'isAvailable', 'reviews', 'shareComponent'));
    }

    public function review(Request $request, Property $property)
    {
        $validated = $request->validate([
            'rating'    => ['required', 'integer', 'between:1,5'],
            'body'      => ['nullable', 'string', 'max:10000'],
        ]);

        $canReview = auth_customer()->bookings()->canBeReviewed($property->id);

        if (!$canReview) {
            throw ValidationException::withMessages(['review' => 'لا تستطيع مراجعة هذا الحجز']);
        }

        auth_customer()->propertyReviews()->syncWithoutDetaching([$property->id => $validated]);
        return response()->json(['success' => 'تم حفظ المراجعة بنجاح']);
    }

    public function destroyReview(Property $property)
    {
		auth_customer()->propertyReviews()->detach($property->id);
        return route('home');
    }
    
    public function governorates(Request $request, Governorate $governorate)
    {
        if ($request->expectsJson()) {
            return response()->json($governorate->regions); 
        }
    }
}
