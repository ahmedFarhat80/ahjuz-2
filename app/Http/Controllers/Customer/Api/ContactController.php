<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        Contact::create($request->validated());
        return response()->json(['message' => 'تم الإرسال بنجاح'], 200); 
    }
}
