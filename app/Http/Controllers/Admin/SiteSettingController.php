<?php

namespace App\Http\Controllers\Admin;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SiteSettingRequest;

class SiteSettingController extends Controller
{
    public function index() {
        return view('admin.settings.index', ['settings' => SiteSetting::first()]);
    }

    public function update(SiteSettingRequest $request) {

        $attributes = $request->validated();

        if ($request->hasFile('hero_img')) {
            Storage::disk('public')->delete(SiteSetting::first()->getRawOriginal('hero_img'));
            $attributes['hero_img'] = img_upload($request->file('hero_img'), SiteSetting::STOREAGE);
        }
        if ($request->hasFile('about_img')) {
            Storage::disk('public')->delete(SiteSetting::first()->getRawOriginal('about_img'));
            $attributes['about_img'] = img_upload($request->file('about_img'), SiteSetting::STOREAGE);
        }
        
        SiteSetting::first()->update($attributes);

        return redirect()->route('admin.settings')->with(toastNotification('الإعدادات', 'updated'));
    }
}
