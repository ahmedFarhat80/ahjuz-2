<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\DataTables\AdminsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;

class AdminController extends Controller
{
    public function index(AdminsDataTable $dataTable)
    {
        return $dataTable->render('admin.admins.table.index');
    }

    public function store(StoreAdminRequest $request)
    {
        return Admin::create($request->validated());
    }
    
    public function show(Admin $admin)
    {
        return view('admin.admins.details.index', compact('admin'));
    }

    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $attributes = $request->validated();
    
        if ($request->avatar_remove || $request->hasFile('avatar')) {
            Storage::disk('public')->delete($admin->getRawOriginal('avatar'));
            $attributes['avatar'] = null;
        }

        if ($request->hasFile('avatar')) {
            $attributes['avatar'] = img_upload($request->file('avatar'), Admin::AVATARS_STOREAGE, true);
        }
    
        return $admin->update($attributes);
    }

    public function destroy(Request $request, Admin $admin)
    {
        if ($request->expectsJson()) {
            Storage::disk('public')->delete($admin->getRawOriginal('avatar'));
            $admin->delete();
            return route('admin.admins.index');
        } 
    }

}
