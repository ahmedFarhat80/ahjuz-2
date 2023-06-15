<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteSettingRequest extends FormRequest
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
            'main_headline' => 'nullable|string',
            'main_text' => 'nullable|string',
            'mobile_headline' => 'nullable|string',
            'mobile_text' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'whatsapp_1' => 'nullable|string',
            'whatsapp_2' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'about_text' => 'nullable|string',
            'email' => 'nullable|string',

            'play_store' => 'nullable|url',
            'apple_store' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'snapchat' => 'nullable|url',
            'youtube' => 'nullable|url',
            
            'hero_img' => ['nullable', 'file','mimes:jpeg,png,jpg,svg', 'max:8192'],
            'about_img' => ['nullable', 'file','mimes:jpeg,png,jpg,svg', 'max:8192'],
        ];
    }
}