<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\PaymentMethod;
use App\Traits\DateScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    use DateScopesTrait;

    protected $guarded = [];
    protected $casts = ['status' => BookingStatus::class, 'payment_method' => PaymentMethod::class];
    public $dates = ['starts_at', 'ends_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function scopeCheck($q, $start, $end)
    {
        return $q
                ->where('starts_at', '<', $end)
                ->where('ends_at', '>', $start)
                ->where('status', BookingStatus::Paid);
    }

    public function scopeNotForeign($q)
    {
        return $q->where('bookings.is_foreign', 0);
    }

    public function scopeCanBeReviewed($q, $property_id)
    {
        return $q
            ->where('property_id', $property_id)
            ->where('starts_at', '<=', today())
            ->where('status', BookingStatus::Paid)
            ->exists();
    }
}
