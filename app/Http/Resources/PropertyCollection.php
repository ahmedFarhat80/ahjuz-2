<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyCollection extends ResourceCollection
{
    public function __construct($resource, $date)
    {
        parent::__construct($resource);
        $this->date = $date;
    }
    
    public function toArray($request)
    {
        return $this->collection->map(fn($property) =>
            [
                'id'                        =>      $property->id,
                'name'                      =>      $property->name,
                'slug'                      =>      $property->slug,
                'price_average'             =>      $property->average_price(Carbon::parse($this->date->starts_at), Carbon::parse($this->date->ends_at), $this->date->days),
                'insurance_price'           =>      $property->insurance_price,
                'type'                      =>      $property->type->description,
                'is_special'                =>      $property->is_special->description,
                'status'                    =>      $property->status->description,
                'reviews_count'             =>      $property->reviews_count,
                'reviews_avg_rating'        =>      $property->reviews_avg_rating,
                'views'                     =>      views($property->resource)->remember(12*60)->count(),
                'address'                   =>      $property->address,
                'imgs'                      =>      $property->imgs->take(5),
                'created_at'                =>      $property->created_at,
                'updated_at'                =>      $property->updated_at,
            ]
        );
    }
}