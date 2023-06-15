<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth_owner()->notifications()->latest()->paginate(10);
        return view('owner.notifications', compact('notifications'));
    }
}
