<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          =>  'required|string|min:2|max:20',
            'phone'         =>  'required|digits:8|unique:admins',
            'email'         =>  'required|email|max:255|unique:admins',
            'password'      =>  [Rule::requiredIf(!$this->admin), 'string', 'min:8', 'confirmed'],
        ];
    }
}
