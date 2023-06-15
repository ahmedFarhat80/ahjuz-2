<?php

namespace App\Models;

use App\Traits\HasPhoneNumber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasPhoneNumber;

    const AVATARS_STOREAGE = 'media/admins/avatars/';

    protected $guarded = [];
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value) {
        return $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }
    
    public function getAvatarAttribute($value) 
    {
        return asset($value ? 'storage/'. $value : 'frontend/img/avatar.png');
    }

}
