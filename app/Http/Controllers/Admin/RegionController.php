<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\DataTables\RegionsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;

class RegionController extends Controller
{
    public function index(RegionsDataTable $dataTable)
    {
        return $dataTable->render('admin.regions.table.index', ['governorates' => Governorate::pluck('name', 'id')]);
    }

    public function store(StoreRegionRequest $request)
    {
        return Region::create($request->validated());
    }
    
    public function show(Region $region)
    {
        return view('admin.regions.details.index', [
            'region'    => $region,
            'governorates' => Governorate::pluck('name', 'id')
        ]);
    }

    public function update(UpdateRegionRequest $request, Region $region)
    {
        $region->update($request->validated());
        return redirect()->route('admin.regions.index')->with(toastNotification('المنطقة', 'updated'));
    }

    public function destroy(Request $request, Region $region)
    {
        if ($request->expectsJson()) {
            $region->delete();
            return route('admin.regions.index');    
        } 
    }

}
