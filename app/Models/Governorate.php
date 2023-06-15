<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    
    const COVERS_STOREAGE = 'media/governorates/covers/';

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function getCoverAttribute($value) 
    {
        return asset($value ? 'storage/'. $value : 'frontend/img/city.png');
    }
}
