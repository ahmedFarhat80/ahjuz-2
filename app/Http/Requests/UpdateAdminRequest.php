<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          =>  'required|string|min:2|max:20',
            'phone'         =>  'required|digits:8|unique:admins,phone,' . $this->admin->id,
            'email'         =>  'required|email|max:255|unique:admins,email,' . $this->admin->id,
            'avatar'        =>  'nullable|file|mimes:jpeg,png,jpg,svg|max:8096',
        ];
    }
}
