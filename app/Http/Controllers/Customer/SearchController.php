<?php

namespace App\Http\Controllers\Customer;

use Carbon\Carbon;
use App\Models\Region;
use App\Models\Property;
use App\Enums\PropertyType;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Services\SearchService;
use App\Services\BookingService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $properties = SearchService::results((object)$request->all())->paginate(5);

        if ($request->expectsJson()) {

            $pagination = $properties->appends(request()->except('page'))->links()->render();
            $properties_html = view('customer.search.properties',  compact('properties'))->render();
            $properties_count = $properties->total();

            return response()->json(compact('pagination', 'properties_html', 'properties_count'));    
        } else {

            $types = PropertyType::getPluralDescriptions();
            $governorates  = Governorate::pluck('name', 'id');
            $regions  = Region::where('governorate_id', $request->governorate_id)->pluck('name', 'id');
            
            $request->starts_at && $request->ends_at 
                ? Session::put('date', BookingService::setDates($request->starts_at, $request->ends_at))
                : Session::put('date', BookingService::setDates(today()->format('Y/m/d'), today()->addDay()->format('Y/m/d')));
    
            return view('customer.search.index', compact('properties', 'types', 'governorates', 'regions'));    
        }
    }

    public function autocompleteSearch(Request $request)
    {
        return response()->json(SearchService::autocomplete($request->get('query')));
    } 
}
