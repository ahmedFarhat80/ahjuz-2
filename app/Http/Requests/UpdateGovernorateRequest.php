<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGovernorateRequest extends FormRequest
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
            'name'          =>  'required|min:2|max:30|unique:governorates,name,' . $this->governorate->id,
            'cover'         =>  'nullable|file|mimes:jpeg,png,jpg,svg|max:8096',
        ];
    }
}
