<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate($request->page_size ?? 10);
        return response()->json(compact('notifications'), 200); 
    }

}
