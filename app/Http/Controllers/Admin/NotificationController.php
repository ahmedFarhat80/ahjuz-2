<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth_admin()->notifications()->latest()->paginate(1);
        return view('admin.profile.notifications', compact('notifications'));
    }
}
