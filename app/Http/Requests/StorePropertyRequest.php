<?php

namespace App\Http\Requests;

use App\Enums\PropertyFor;
use App\Enums\PropertyType;
use Illuminate\Support\Str;
use App\Enums\PropertyIsActive;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'              =>      'required|string|min:10|max:50|unique:properties',
            'slug'              =>      'required|string|unique:properties',
            'day_price'         =>      'required|numeric|min:1',
            'thursday_price'    =>      'required|numeric|min:1',
            'friday_price'      =>      'required|numeric|min:1',
            'insurance_price'   =>      'nullable|numeric|min:0',
            'type'              =>      ['required', new EnumValue(PropertyType::class, false)],
            'description'       =>      'required|string|min:20',
            'area'              =>      'required|numeric|min:10',
            'for'               =>      ['required', new EnumValue(PropertyFor::class, false)],
            'opens_at'          =>      'required|date_format:H:i',
            'closes_at'         =>      'required|date_format:H:i',
            'imgs'              =>      'required|min:5|max:20',
            'is_active'         =>    [new EnumValue(PropertyIsActive::class, false)],

            //address
            'governorate_id'    =>      'required|exists:governorates,id',
            'region_id'         =>      'required|exists:regions,id',
            'address_details'   =>      'required|string|min:10',
            'longitude'         =>      'required|numeric',
            'latitude'          =>      'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'imgs.min' => 'يجب أن يحتوي حقل :attribute على الأقل على :min صورة/صور.',
            'imgs.max' => 'يجب أن لا يحتوي حقل :attribute على أكثر من :max صورة/صور.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name , '-', null),
        ]);
    }
}