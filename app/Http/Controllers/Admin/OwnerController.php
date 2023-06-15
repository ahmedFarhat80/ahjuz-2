<?php

namespace App\Http\Controllers\Admin;

use App\Models\Owner;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use App\DataTables\OwnersDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;

class OwnerController extends Controller
{
    public function index(OwnersDataTable $dataTable)
    {
        return $dataTable->render('admin.owners.table.index');
    }

    public function store(StoreOwnerRequest $request)
    {
        return Owner::create($request->validated());
    }
    
    public function show(Owner $owner)
    {
        $owner->loadSum(['bookings' => fn($q) => $q->where('bookings.status', BookingStatus::Paid)], 'subtotal_price');
        $owner->loadSum(['bookings' => fn($q) => $q->where('bookings.status', BookingStatus::Paid)], 'discount');
        $owner->loadCount(["bookings" => fn($q) => $q->notForeign()]);
        $properties = $owner->properties()->paginate(5);
        return view('admin.owners.details.index', compact('owner', 'properties'));
    }

    public function update(UpdateOwnerRequest $request, Owner $owner)
    {
        $attributes = $request->validated();
    
        if ($request->avatar_remove || $request->hasFile('avatar')) {
            Storage::disk('public')->delete($owner->getRawOriginal('avatar'));
            $attributes['avatar'] = null;
        }

        if ($request->hasFile('avatar')) {
            $attributes['avatar'] = img_upload($request->file('avatar'), Owner::AVATARS_STOREAGE, true);
        }
    
        return $owner->update($attributes);
    }

    public function destroy(Request $request, Owner $owner)
    {
        if ($request->expectsJson()) {
            Storage::disk('public')->delete($owner->getRawOriginal('avatar'));
            $owner->delete();
            return route('admin.owners.index');    
        } 
    }
}
