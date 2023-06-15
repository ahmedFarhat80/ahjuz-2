<?php

namespace App\Http\Controllers\Admin;

use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\DataTables\GovernoratesDataTable;
use App\Http\Requests\StoreGovernorateRequest;
use App\Http\Requests\UpdateGovernorateRequest;

class GovernorateController extends Controller
{
    public function index(GovernoratesDataTable $dataTable)
    {
        return $dataTable->render('admin.governorates.table.index');
    }

    public function store(StoreGovernorateRequest $request)
    {
        $attributes = $request->validated();

        if ($request->hasFile('cover')) {
            $attributes['cover'] = img_upload($request->file('cover'), Governorate::COVERS_STOREAGE);
        }

        return Governorate::create($attributes);
    }
    
    public function show(Governorate $governorate)
    {
        return view('admin.governorates.details.index', ['governorate'    => $governorate]);
    }

    public function update(UpdateGovernorateRequest $request, Governorate $governorate)
    {
        $attributes = $request->validated();
        
        if ($request->hasFile('cover')) {
            Storage::disk('public')->delete($governorate->getRawOriginal('cover'));
            $attributes['cover'] = img_upload($request->file('cover'), Governorate::COVERS_STOREAGE);
        }
        
        $governorate->update($attributes);
        return redirect()->route('admin.governorates.index')->with(toastNotification('المحافظة', 'updated'));
    }

    public function destroy(Request $request, Governorate $governorate)
    {
        if ($request->expectsJson()) {
            Storage::disk('public')->delete($governorate->getRawOriginal('cover'));
            $governorate->delete();
            return route('admin.governorates.index');    
        } 
    }
}
