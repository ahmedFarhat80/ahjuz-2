<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAddress extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['governorate', 'region'];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
