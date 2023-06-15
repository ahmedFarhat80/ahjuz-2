<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingPropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                 =>      $this->id,
            'name'               =>      $this->name,
            'slug'               =>      $this->slug,
            'is_special'         =>      $this->is_special->description,
            'views'              =>      views($this->resource)->remember(12*60)->count(),
            'address'            =>      $this->address,
            'imgs'               =>      $this->imgs->take(5),
            'reviews'            =>      $this->whenLoaded('reviews'),
        ];
    }
}
