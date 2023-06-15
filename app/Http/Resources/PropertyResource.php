<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Services\BookingService;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $date = $this->additional['date'];

        return [
            'id'                        =>      $this->id,
            'name'                      =>      $this->name,
            'slug'                      =>      $this->slug,
            'price_average'             =>      $this->average_price(Carbon::parse($date->starts_at), Carbon::parse($date->ends_at), $date->days),
            'insurance_price'           =>      $this->insurance_price,
            'type'                      =>      $this->type->description,
            'description'               =>      $this->description,
            'area'                      =>      $this->area,
            'for'                       =>      $this->for->description,
            'opens_at'                  =>      $this->opens_at,
            'closes_at'                 =>      $this->closes_at,
            'is_special'                =>      $this->is_special->description,
            'status'                    =>      $this->status->description,
            'isAvailable'               =>      $this->isAvailable($date->starts_at, $date->ends_at),
            'reviews_count'             =>      $this->reviews_count,
            'reviews_avg_rating'        =>      $this->reviews_avg_rating,
            'imgs'                      =>      $this->imgs,
            'address'                   =>      $this->address,
            'created_at'                =>      $this->created_at,
            'updated_at'                =>      $this->updated_at,
        ];
    }
}