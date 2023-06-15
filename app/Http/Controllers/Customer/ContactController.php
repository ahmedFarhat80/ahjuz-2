<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('customer.contact-us');
    }

    public function store(ContactRequest $request)
    {
        Contact::create($request->validated());
        return redirect()->route('landing-page.index')->with(toastNotification('تم الإرسال بنجاح'));
    }
}
