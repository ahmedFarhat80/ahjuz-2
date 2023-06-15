<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\PropertyFor;
use App\Enums\PropertyType;
use App\Enums\BookingStatus;
use App\Enums\PropertyStatus;
use App\Enums\PropertyIsActive;
use App\Enums\PropertyIsSpecial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model implements Viewable

{
    use HasFactory;
    use InteractsWithViews;

    // const COVERS_STOREAGE = 'media/properties/covers/';

    protected $guarded = [];
    protected $casts = ['type' => PropertyType::class, 'for' => PropertyFor::class, 'is_special' => PropertyIsSpecial::class, 'is_active' => PropertyIsActive::class, 'status' => PropertyStatus::class];
    protected $dates = ['opens_at', 'closes_at'];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function address()
    {
        return $this->hasone(PropertyAddress::class);
    }

    public function imgs()
    {
        return $this->hasMany(PropertyImg::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    public function getCodeAttribute() 
    {
        return sprintf('%05d', $this->id);
    }

    public function getGovRegAttribute() 
    {
        return sprintf('%s - %s',  $this->address->governorate->name, $this->address->region->name);
    }

    public function getOpensAtArAttribute() 
    {
        return Carbon::parse($this->opens_at)->locale('ar')->isoFormat('hh:mm A');
    }

    public function getClosesAtArAttribute() 
    {
        return Carbon::parse($this->closes_at)->locale('ar')->isoFormat('hh:mm A');
    }

    public function getShowPriceAttribute($v) 
    {
        return number_format($this->price);
    }

    public function getActiveClassAttribute()
    {
        switch ($this->is_active->value) {
            case PropertyIsActive::No:
                return 'danger'; break;
            case PropertyIsActive::Yes:
                return 'success'; break;
        }
    }

    public function getStatusClassAttribute()
    {
        switch ($this->status->value) {
            case PropertyStatus::Pending:
                return 'warning'; break;
            case PropertyStatus::Accepted:
                return 'success'; break;
            case PropertyStatus::Rejected:
                return 'danger'; break;
            case PropertyStatus::Suspended:
                return 'dark'; break;
        }
    }

    public function getTodayPriceAttribute()
    {
        return today()->isThursday() ? $this->thursday_price : (today()->isFriday() ?  $this->friday_price : $this->day_price);
    }

    public static function getTodayPriceCol()
    {
        return today()->isThursday() ? 'properties.thursday_price' : (today()->isFriday() ?  'properties.friday_price' : 'properties.day_price');
    }

    public function is_active($type)
    {
        switch ($type) {
            case 'toggle':
                return $this->is_active->is(PropertyIsActive::Yes) ? PropertyIsActive::No : PropertyIsActive::Yes; break;
            case 'checked':
                return $this->is_active->is(PropertyIsActive::Yes) ? 'checked' : ''; break;
            case 'text':
                return $this->is_active->is(PropertyIsActive::Yes) ? 'إلغاء' : ''; break;
        }
    }
    
    public function getAveragePriceAttribute()
    {
        $date = Session::get('date');

        if ($date) {
            $starts_at = Carbon::parse($date->starts_at);
            $ends_at = Carbon::parse($date->ends_at);
            $days = $date->days;
        }

        return $date ?  $this->average_price($starts_at, $ends_at, $days) : $this->today_price; 
    }

    public function getAveragePriceShowAttribute()
    {
        return number_format($this->averagePrice, 2);
    }

    public function getCanBeShownAttribute()
    {
        return $this->is_active->is(PropertyIsActive::Yes) && $this->status->is(PropertyStatus::Accepted);
    }

    public function getAvatarAttribute() 
    {
        return $this->imgs->first()->name;
    }

    public function scopeAvailable($q, $start, $end)
    {
        return $q->canBeShown()->whereDoesntHave('bookings', fn($q) => $q->check($start, $end));
    }

    public function scopeCanBeShown($q)
    {
        return $q
                ->where('is_active', PropertyIsActive::Yes)
                ->where('status', PropertyStatus::Accepted);
    }

    public function scopeSearch($q, $query)
    {
        return $q
            ->leftJoin('property_addresses', 'properties.id', 'property_addresses.property_id')
            ->leftJoin('governorates', 'governorates.id', 'property_addresses.governorate_id')
            ->leftJoin('regions', 'regions.id', 'property_addresses.region_id')
            ->where('properties.name', 'LIKE', "%$query%")
            ->orWhere('governorates.name', 'LIKE', "%$query%")
            ->orWhere('regions.name', 'LIKE', "%$query%")
            ->orWhere('properties.description', 'LIKE', "%$query%")
            ->orWhere('properties.id', $query);
    }

    public function isAvailable($start, $end)
    {
        return $this->canBeShown && $this->bookings()->check($start, $end)->doesntExist();
    }

    public function getTotalPrice($price, $days, $coupon)
    {
        $subtotal = $price * $days;
        $discount = $coupon ? $coupon->getDiscount($subtotal) : 0;
        return $subtotal - $discount + $this->insurance_price;
    }

    public function average_price($starts_at, $ends_at, $days)
    {
        $getDays = self::getDays($starts_at, $ends_at);
        
        return ($getDays['thursdays'] * $this->thursday_price + $getDays['fridays'] * $this->friday_price + $getDays['normal_days'] * $this->day_price) / $days;
    }
    
    public static function getDays($starts_at, $ends_at)
    {
        $days = $starts_at->diffInDays($ends_at);

        $starts_at_clone = clone $starts_at;
        $thursdays = 0;

        $startDate = $starts_at_clone->modify('this thursday');
        for ($date = $startDate; $date->lt($ends_at); $date->addWeek()) {
            $thursdays++;
        }

        $starts_at_clone = clone $starts_at;
        $fridays = 0;

        $startDate = $starts_at_clone->modify('this friday');
        for ($date = $startDate; $date->lt($ends_at); $date->addWeek()) {
            $fridays++;
        }

        $normal_days = $days - $thursdays - $fridays;

        return compact('thursdays', 'fridays', 'normal_days');
    }

}
