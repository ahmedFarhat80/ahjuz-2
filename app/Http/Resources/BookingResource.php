<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'id' => $this->id, 
            'property_id' => $this->property_id, 
            'customer_id' => $this->customer_id, 
            'coupon_id' => $this->coupon_id, 
            'payment_method' => $this->payment_method->description, 
            'insurance' => $this->insurance, 
            'discount' => $this->discount, 
            'total_price' => $this->total_price, 
            'status' => $this->status->description, 
            'starts_at' => $this->starts_at, 
            'ends_at' => $this->ends_at, 
            'created_at' => $this->created_at, 
            'updated_at' => $this->updated_at, 
            'property' => new BookingPropertyResource($this->property), 
        ];
    }
}