<?php

namespace App\Http\Controllers\Admin;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommissionController extends Controller
{
    public function index() {
        return view('admin.commission.index', ['settings' => SiteSetting::first()]);
    }

    public function update(Request $request) {
        $attributes = $request->validate(['commission' => 'required|numeric|between:0,100']);
        SiteSetting::first()->update($attributes);
        return redirect()->route('admin.commission')->with(toastNotification('العمولة', 'updated'));
    }
}
