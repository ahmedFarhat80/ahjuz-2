<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    const COVERS_STOREAGE = 'media/promotions/covers/';

    public function getCoverAttribute($value) 
    {
        return asset('storage/'. $value);
    }
}
