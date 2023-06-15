<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyImgRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file.*' => 'file|mimes:jpeg,png,jpg,svg|max:8192',
            'file' => 'required',
        ];
    }
}
