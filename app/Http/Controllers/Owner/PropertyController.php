<?php

namespace App\Http\Controllers\Owner;

use App\Models\Admin;
use App\Models\Property;
use App\Enums\PropertyFor;
use App\Enums\PropertyType;
use App\Models\Governorate;
use App\Models\PropertyImg;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\PropertyAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\StorePropertyImgRequest;
use App\Notifications\PropertyIsCreatedNotification;
use App\Notifications\PropertyStatusNotification;

class PropertyController extends Controller
{
    public function index()
    {
        auth_owner()->unreadNotifications->where('type', PropertyStatusNotification::class)->markAsRead();

        return view('owner.properties.index', [
            'properties' => auth_owner()->properties()->with(['address', 'imgs'])->get()
        ]);
    }
    
    public function create()
    {
        if (Session::get('property_create')) {
            return redirect()->route('owner.properties.terms');
        }

        return view('owner.properties.create.index', [
            'types'         => PropertyType::asSelectArray(),
            'for'           => PropertyFor::asSelectArray(),
            'governorates'  => Governorate::pluck('name', 'id'),
        ]);
    }

    public function store(StorePropertyRequest $request)
    {
        $attributes = $request->validated();
        
        Session::put('property_create',  $attributes);

        return redirect()->route('owner.properties.terms');
    }

    public function terms()
    {
        if (!Session::get('property_create')) {
            return redirect()->route('owner.properties.create');
        }

        return view('owner.properties.create.terms');
    }
    
    public function agreeTerms(Request $request)
    {
        $request->validate(['terms' => 'accepted']);

        $attributes = Session::get('property_create');

        if (!$attributes) {
            return redirect()->route('owner.properties.create');
        }

        DB::transaction(function () use ($attributes)
        {
            // rename address_details to details
            $attributes['details'] = $attributes['address_details'];
            unset($attributes['address_details']);

            // create property without address & img, add owner_id to attributes array
            $address = ['governorate_id', 'region_id', 'details', 'longitude', 'latitude'];  
            $property = Property::create(Arr::except($attributes, array_merge(['imgs'], $address)) + ['owner_id' => auth_owner()->id]);

            // create property address with only address array, add property_id to attributes array
            PropertyAddress::create(Arr::only($attributes, $address) + ['property_id' => $property->id]);

            // create property imgs and move img from tmp folder to PropertyImg::STOREAGE
            $property_create_imgs = $attributes['imgs'];
            $data = ['property_id' => $property->id, 'created_at' => now(), 'updated_at' => now()];

            $imgs = array_map(fn($img) => move_tmp($img, PropertyImg::STOREAGE), $property_create_imgs); 

            DB::table('property_imgs')->insert(
                array_map(fn($img) => ['name' => $img] + $data , $imgs)
            );
            
            Notification::send(Admin::all(), new PropertyIsCreatedNotification($property));
        });

        return redirect()->route('owner.properties.success');
    }

    public function success()
    {
        if (!Session::get('property_create')) {
            return redirect()->route('owner.properties.create');
        }

        Session::forget('property_create');
        Session::save();

        return view('owner.properties.create.success');
    }

    public function edit(Property $property)
    {
        $this->authorize('manage', $property);

        return view('owner.properties.edit', [
            'property'      => $property,
            'types'         => PropertyType::asSelectArray(),
            'for'           => PropertyFor::asSelectArray(),
            'governorates'  => Governorate::pluck('name', 'id'),
        ]);
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $attributes = $request->validated();

        DB::transaction(function () use ($attributes, $property)
        {
            // rename address_details to details
            $attributes['details'] = $attributes['address_details'];
            unset($attributes['address_details']);

            // update property without address & img
            $address = ['governorate_id', 'region_id', 'details', 'longitude', 'latitude'];  
            $property->update(Arr::except($attributes, array_merge(['imgs'], $address)));

            // update property address with only address array
            $property->address->update(Arr::only($attributes, $address));

            // create the new property imgs and move img from tmp folder to PropertyImg::STOREAGE
            $property_create_imgs = array_filter($attributes['imgs'], fn($v) => str_contains($v, 'tmp'));
            $data = ['property_id' => $property->id, 'created_at' => now(), 'updated_at' => now()];

            $imgs = array_map(fn($img) => move_tmp($img, PropertyImg::STOREAGE), $property_create_imgs); 

            DB::table('property_imgs')->insert(
                array_map(fn($img) => ['name' => $img] + $data , $imgs)
            );
        });

        return redirect()->route('owner.properties.edit', $property->id)->with(toastNotification('الوحدة', 'updated'));
    }

    public function destroy(Request $request, Property $property)
    {
        $this->authorize('manage', $property);

        if ($request->expectsJson()) {
            Storage::disk('public')->delete($property->imgs->map(fn($img) => $img->getRawOriginal('name'))->toArray());
            $property->delete();
        }
    }

    public function storeImg(StorePropertyImgRequest $request)
    {
        if ($request->expectsJson() && $request->hasFile('file')) {
            return img_upload($request->file('file'), 'tmp/', false);
        }
    }
    
    public function destroyImg(Request $request)
    {

        // can destroy img while creating property
        if ($request->expectsJson() && str_contains($request->filename, 'tmp')) {
            return Storage::disk('public')->delete($request->filename);
        }

        // can destroy img while updating property
        try {
            $img = PropertyImg::findOrFail($request->imgID);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'هذه الصورة غير موجودة'], 422);
        }

        $property = $img->property;
        $this->authorize('manage', $property);
        
        if ($property->imgs()->count() <= 5) {
            return response()->json(['message' => 'يجب أن لا يقل عدد الصور عن 5 صور'], 422);
        }

        if ($request->expectsJson()) {
            Storage::disk('public')->delete($img->getRawOriginal('name'));
            $img->delete();
            return $img->name;
        }
    }

    public function updateStatus(Property $property) {
        $property->update(['is_active' => $property->is_active('toggle')]);
        return redirect()->route('owner.home')->with(toastNotification('الوحدة', 'updated'));
    }

    public function governorates(Request $request, Governorate $governorate)
    {
        if ($request->expectsJson()) {
            return response()->json($governorate->regions); 
        }
    }
}
