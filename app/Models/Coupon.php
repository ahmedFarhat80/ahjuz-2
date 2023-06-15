<?php

namespace App\Models;

use App\Enums\CouponType;
use App\Enums\CouponStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = ['type' => CouponType::class, 'status' => CouponStatus::class];
    protected $dates = ['starts_at', 'ends_at'];

    public function  scopeActive($q){
        return $q->where('status', CouponStatus::Active);
    }
   
    public function scopeValid($q, $code) {
        $q->where('code', $code)
        ->where(fn($q) => 
            $q->where(fn($q) =>
                $q->where('max_use_count', '<>', 0)->whereColumn('use_count', '<', 'max_use_count')
            )
            ->orWhere('max_use_count', 0)
        )
        ->active();
    }

    public function getDiscount($price)
    {
        return $this->type->is(CouponType::Percent) ?  $price * $this->value / 100 : $this->value;
    }
}
