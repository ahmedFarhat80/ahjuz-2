<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOwnerRequest  extends FormRequest
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
            'phone'         =>  'required|digits:8|unique:owners,phone,' .  auth_owner()->id ?? $this->owner->id,
            'email'         =>  'required|email|max:255|unique:owners,email,' .  auth_owner()->id ?? $this->owner->id,
            'avatar'        =>  'nullable|file|mimes:jpeg,png,jpg,svg|max:8096',
        ];
    }
}