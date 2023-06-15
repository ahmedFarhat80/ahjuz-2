<?php

namespace App\Models;

use App\Traits\HasPhoneNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasPhoneNumber;

    const AVATARS_STOREAGE = 'media/customers/avatars/';

    protected $guarded = [];
    protected $hidden = [
        'remember_token',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    public function code()
    {
        return $this->hasOne(UserApiCode::class);
    }
    
    public function propertyReviews() {
        return $this->belongsToMany(Property::class, 'reviews')->withTimestamps();
    }

    public function getAvatarAttribute($value) 
    {
        return asset($value ? 'storage/'. $value : 'frontend/img/avatar.png');
    }

    public function getFullNameAttribute() 
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }
    
}
