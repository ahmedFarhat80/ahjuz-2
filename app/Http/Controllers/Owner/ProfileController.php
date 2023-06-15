<?php

namespace App\Http\Controllers\Owner;

use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateOwnerRequest;

class ProfileController extends Controller
{
    public function edit() 
    {
        return view('owner.profile');
    }

    public function update(UpdateOwnerRequest $request)
    {
        $owner = Owner::findOrFail(auth_owner()->id);

        $attributes = $request->validated();

        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete($owner->getRawOriginal('avatar'));
            $attributes['avatar'] = img_upload($request->file('avatar'), Owner::AVATARS_STOREAGE, true);
        }

        $owner->update($attributes);

        return redirect()->route('owner.home')->with(toastNotification('حسابك', 'updated'));
    }
}
