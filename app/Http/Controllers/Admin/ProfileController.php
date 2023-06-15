<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AdminProfileRequest;

class ProfileController extends Controller
{
    public function edit() {        
        return view('admin.profile.settings');
    }

    public function update(AdminProfileRequest $request) {

        $attributes = $request->validated();
    
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete(auth_admin()->getRawOriginal('avatar'));
            $attributes['avatar'] = img_upload($request->file('avatar'), Admin::AVATARS_STOREAGE, true);
        }

        if (array_key_exists('password', $attributes) && $attributes['password'] == null) {
           unset($attributes['password']);
        }

        if (array_key_exists('password', $attributes)) {
            $attributes['password'] = bcrypt($attributes['password']);
        }
        
        auth_admin()->update($attributes);

        return redirect()->route('admin.dashboard')->with(toastNotification('الحساب', 'updated'));
    }
}
