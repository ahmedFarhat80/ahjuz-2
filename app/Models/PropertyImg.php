<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImg extends Model
{
    use HasFactory;
    protected $guarded = [];

    const STOREAGE = 'media/properties/imgs/';

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    
    public function getNameAttribute($value) {
        return asset('storage/'. $value);
    }

}
