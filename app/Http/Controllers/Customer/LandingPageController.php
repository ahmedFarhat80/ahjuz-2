<?php

namespace App\Http\Controllers\Customer;

use App\Models\Ad;
use App\Models\Property;
use App\Enums\PropertyType;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Enums\PropertyIsSpecial;
use App\Http\Controllers\Controller;

class LandingPageController extends Controller
{
    public function index()
    {
        $types = PropertyType::getPluralDescriptions();
        $governorates  = Governorate::all();
        $properties = Property::with(['address', 'imgs'])->withCount('reviews')->withAvg('reviews', 'rating')->canBeShown()->where('is_special', PropertyIsSpecial::Yes)->get();
        $ads = Ad::all();

        return view('customer.landing-page.index', compact('types', 'governorates', 'properties', 'ads'));
    }
}
