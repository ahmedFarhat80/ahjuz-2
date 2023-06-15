<?php

namespace App\Http\Controllers\Customer\Api;

use Carbon\Carbon;
use App\Models\Region;
use App\Models\Property;
use App\Enums\PropertyType;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Services\SearchService;
use App\Services\BookingService;
use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyMulti;
use App\Http\Resources\PropertyCollection;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $results = SearchService::results((object)$request->all())->paginate($request->page_size ?? 10);
        $date = $this->date($request);
        $properties = (new PropertyCollection($results, $date))->response()->getData(true);
        $regions  = Region::where('governorate_id', $request->governorate_id)->get();
        return response()->json(compact('properties', 'regions', 'date'));
    }

    public function autocompleteSearch(Request $request)
    {
        return response()->json(SearchService::autocomplete($request->get('query')));
    } 

    public function propertiesByType(Request $request, $type)
    {
        $request->request->add(['type' => $type]);
        $results = SearchService::results((object)$request->all())->paginate($request->page_size ?? 10);
        $date = $this->date($request);
        return new PropertyCollection($results, $date);
    }

    private function date($request)
    {
        return $request->starts_at && $request->ends_at 
        ? BookingService::setDates($request->starts_at, $request->ends_at) 
        : BookingService::setDates(today()->format('Y/m/d'), today()->addDay()->format('Y/m/d'));
    }
}
