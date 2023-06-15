<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOwnerRequest  extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name'    =>  'required|alpha|min:2|max:20',
            'last_name'     =>  'required|alpha|min:2|max:20',
            'address'       =>  'required|string|max:100',
            'phone'         =>  'required|digits:8|unique:owners',
            'email'         =>  'required|email|max:255|unique:owners',
        ];
    }
}
