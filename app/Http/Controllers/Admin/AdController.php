<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\DataTables\AdsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\UpdateAdRequest;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function index(AdsDataTable $dataTable)
    {
        return $dataTable->render('admin.ads.table.index');
    }

    public function store(StoreAdRequest $request)
    {
        $attributes = $request->validated();

        if ($request->hasFile('cover')) {
            $attributes['cover'] = img_upload($request->file('cover'), Ad::COVERS_STOREAGE);
        }

        return Ad::create($attributes);
    }
    
    public function show(Ad $ad)
    {
        return view('admin.ads.details.index', compact('ad'));
    }

    public function update(UpdateAdRequest $request, Ad $ad)
    {
        $attributes = $request->validated();
        
        if ($request->hasFile('cover')) {
            Storage::disk('public')->delete($ad->getRawOriginal('cover'));
            $attributes['cover'] = img_upload($request->file('cover'), Ad::COVERS_STOREAGE);
        }
        
        $ad->update($attributes);
        return redirect()->route('admin.ads.index')->with(toastNotification('الإعلان', 'updated'));
    }

    public function destroy(Request $request, Ad $ad)
    {
        if ($request->expectsJson()) {
            Storage::disk('public')->delete($ad->getRawOriginal('cover'));
            $ad->delete();
            return route('admin.ads.index');    
        } 
    }
}
