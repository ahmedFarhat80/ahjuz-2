<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Property;
use Illuminate\Support\Facades\DB;

class SearchService {

    public static function results($data)
    {
        return Property::query()
            ->canBeShown()
            ->with('address', 'imgs')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->when(isset($data->starts_at) &&  isset($data->ends_at), fn($q) => $q->available($data->starts_at, $data->ends_at))
            ->when(isset($data->governorate_id), fn($q) => $q->whereRelation('address', 'governorate_id',  $data->governorate_id))
            ->when(isset($data->region_id), fn($q) => $q->whereRelation('address', 'region_id',  $data->region_id))
            ->when(isset($data->rate), fn($q) => $q->whereHas('reviews', fn($q) => $q->groupBy('property_id')->havingRaw('AVG(rating) >= ' . $data->rate)))
            ->when(isset($data->search), fn($q) => $q->search($data->search))
            ->when(isset($data->type), fn($q) => $q->where('type', $data->type))
            ->when(isset($data->sort), fn($q) => $data->sort == 'most_views' ? $q->orderByViews()  : $q->orderByRaw(self::orderingBy($data->sort, $data->starts_at ?? null, $data->ends_at ?? null)));
    }

    public static function autocomplete($query)
    {
        $data1 = DB::table('properties')
            ->select('properties.name')
            ->where('properties.name', 'LIKE', "%$query%")
            ->pluck('properties.name')->toArray();

        $data2 = DB::table('governorates')
            ->select('governorates.name')
            ->leftJoin('property_addresses', 'governorates.id', 'property_addresses.governorate_id')
            ->where('governorates.name', 'LIKE', "%$query%")
            ->pluck('governorates.name')->toArray();
            
        $data3 = DB::table('regions')
            ->select('regions.name')
            ->leftJoin('property_addresses', 'regions.id', 'property_addresses.region_id')
            ->where('regions.name', 'LIKE', "%$query%")
            ->pluck('regions.name')->toArray();

        return $data1 + $data2 + $data3;
    } 

    private static function orderingBy($data, $starts_at, $ends_at)
    {
        if (!$starts_at && !$ends_at) {
            $today_price_col = Property::getTodayPriceCol();
            switch ($data) {
                case 'lowest_price': 
                    return "$today_price_col ASC"; break;
                case 'highest_price': 
                    return "$today_price_col DESC"; break;
                case 'highest_rating': 
                    return '(SELECT AVG(rating) FROM reviews WHERE properties.id = reviews.property_id) DESC'; break;
            }
        }

        $getDays = Property::getDays(Carbon::parse($starts_at), Carbon::parse($ends_at));

        switch ($data) {
            case 'lowest_price': 
                return "({$getDays['normal_days']} * properties.day_price + {$getDays['thursdays']} * properties.thursday_price + {$getDays['fridays']} * properties.friday_price) / 3 ASC"; break;
            case 'highest_price': 
                return "({$getDays['normal_days']} * properties.day_price + {$getDays['thursdays']} * properties.thursday_price + {$getDays['fridays']} * properties.friday_price) / 3 DESC"; break;
            case 'highest_rating': 
                return '(SELECT AVG(rating) FROM reviews WHERE properties.id = reviews.property_id) DESC'; break;
        }
    }

}