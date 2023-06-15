<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProfileRequest extends FormRequest
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
            'name'          =>  'required|string|min:2|max:20',
            'email'         =>  'required|email|max:255',
            'phone'         =>  'nullable',
            'avatar'        =>  'nullable|file|mimes:jpeg,png,jpg,svg|max:8096',
            'password'      =>  'nullable|string|min:8|confirmed',
        ];
    }
}
