<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth_customer()->notifications()->latest()->paginate(10);
        return view('customer.notifications', compact('notifications'));
    }
}
