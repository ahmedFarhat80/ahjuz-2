<?php

namespace App\Traits;

trait HasPhoneNumber
{
  public function scopePhone($q, $v)
  {
    return $q->where('phone', $v);
  }

  public static function findByPhoneNumber($v)
  {
    return self::phone($v)->first();
  }
}
