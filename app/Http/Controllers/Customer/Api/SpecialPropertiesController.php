<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Enums\PropertyIsSpecial;
use App\Services\BookingService;
use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyCollection;

class SpecialPropertiesController extends Controller
{
    public function index()
    {
        $date = BookingService::setDates(today()->format('Y/m/d'), today()->addDay()->format('Y/m/d'));
        $results =  Property::with(['address', 'imgs'])->withCount('reviews')->withAvg('reviews', 'rating')->canBeShown()->where('is_special', PropertyIsSpecial::Yes)->get();
        return new PropertyCollection($results, $date);
    }
}
