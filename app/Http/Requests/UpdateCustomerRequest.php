<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = auth_customer()->id ?? ($this->user('sanctum')->id ?? $this->customer->id);
        return [
            'first_name'    =>  'required|alpha|min:2|max:20',
            'last_name'     =>  'required|alpha|min:2|max:20',
            'address'       =>  'required|string|max:100',
            'phone'         =>  'required|digits:8|unique:customers,phone,' . $id,
            'email'         =>  'required|email|max:255|unique:customers,email,' . $id,
            'avatar'        =>  'nullable|file|mimes:jpeg,png,jpg,svg|max:8096',
        ];
    }
}
