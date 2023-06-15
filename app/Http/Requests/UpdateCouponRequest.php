<?php

namespace App\Http\Requests;

use App\Enums\CouponType;
use App\Enums\CouponStatus;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'          => 'required|string|max:50|unique:coupons,code,' . $this->coupon->id,
            'type'          => [new EnumValue(CouponType::class, false)],
            'value'         => ['required', 'numeric', $this->type  == CouponType::Percent ? 'between:0,100' : 'min:0'],
            'status'        => [new EnumValue(CouponStatus::class, false)],
            'max_use_count' => 'required|numeric|min:0',
            'starts_at'    => 'required|date|before:ends_at',
            'ends_at'    => 'required|date|after:today',
        ];
    }
}
