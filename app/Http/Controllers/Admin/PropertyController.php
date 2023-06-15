<?php

namespace App\Http\Controllers\Admin;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Enums\PropertyStatus;
use App\Enums\PropertyIsSpecial;
use BenSampo\Enum\Rules\EnumKey;
use App\Http\Controllers\Controller;
use App\DataTables\PropertiesDataTable;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PropertyStatusNotification;
use App\Notifications\PropertyIsCreatedNotification;

class PropertyController extends Controller
{
    public function index(PropertiesDataTable $dataTable)
    {
        return $dataTable->render('admin.properties.table.index');
    }

    public function show(Property $property)
    {
        auth_admin()->unreadNotifications->where('type', PropertyIsCreatedNotification::class)->where('data.property_id', $property->id)->markAsRead();

        return view('admin.properties.details.index', compact('property'));
    }

    public function update(Request $request, Property $property) {

        if ($request->status) {
            $status = $request->validate(['status' => new EnumKey(PropertyStatus::class)])['status'];
            $property->update(['status' => constant("PropertyStatus::$status")]);
        }

        if ($request->is_special) {
            $is_special = $request->validate(['is_special' => new EnumKey(PropertyIsSpecial::class)])['is_special'];
            $property->update(['is_special' => constant("PropertyIsSpecial::$is_special")]);
        }

        $text = isset($status) ? PropertyStatus::getNoun(constant("PropertyStatus::$status")) : PropertyIsSpecial::getNoun(constant("PropertyIsSpecial::$is_special"));

        return $property->owner->notify(new PropertyStatusNotification($text));
    }

    public function destroy(Request $request, Property $property)
    {
        if ($request->expectsJson()) {
            Storage::disk('public')->delete($property->imgs->map(fn($img) => $img->getRawOriginal('name'))->toArray());
            $property->delete();
            return route('admin.properties.index');    
        }
    }
}
