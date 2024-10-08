<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }
}
