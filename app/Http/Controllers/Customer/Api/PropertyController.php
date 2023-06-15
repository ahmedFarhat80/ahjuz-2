<?php

namespace App\Http\Controllers\Customer\Api;

use Carbon\Carbon;
use App\Models\Property;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Jorenvh\Share\ShareFacade;
use App\Services\BookingService;
use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use Illuminate\Validation\ValidationException;

class PropertyController extends Controller
{
    public function show(Request $request, Property $property)
    {
        if (!$property->canBeShown) {
            return response()->json(['message' => 'Forbidden'], 403); 
        }

        $property->loadAvg('reviews', 'rating');

        $date = $request->starts_at && $request->ends_at 
            ? BookingService::setDates($request->starts_at, $request->ends_at) 
            : BookingService::setDates(today()->format('Y/m/d'), today()->addDay()->format('Y/m/d'));

        $share = ShareFacade::page(route('properties.show', $property->slug),'')
            ->facebook()
            ->twitter()
            ->telegram()
            ->whatsapp()
            ->getRawLinks();

        views($property)->cooldown(24*60)->record();

        $property = (new PropertyResource($property))->additional(['date' => $date]);

        return response()->json(compact('property', 'date', 'share'), 200); 
    }

    public function reviews(Request $request, Property $property)
    {
        return $property->reviews()->with('customer')->latest()->paginate($request->page_size ?? 10);
    }
    
    public function review(Request $request, Property $property)
    {
        $validated = $request->validate([
            'rating'    => ['required', 'integer', 'between:1,5'],
            'body'      => ['nullable', 'string', 'max:10000'],
        ]);

        $canReview = $request->user()->bookings()->canBeReviewed($property->id);

        if (!$canReview) {
            return response()->json(['message' => 'لا تستطيع مراجعة هذا الحجز'], 403); 
        }

        $request->user()->propertyReviews()->syncWithoutDetaching([$property->id => $validated]);

        return response()->json(['success' => 'تم حفظ المراجعة بنجاح'], 200);
    }

    public function destroyReview(Request $request, Property $property)
    {
		$request->user()->propertyReviews()->detach($property->id);
        return response()->json(['success' => 'تم حذف المراجعة بنجاح'], 200);
    }
}
