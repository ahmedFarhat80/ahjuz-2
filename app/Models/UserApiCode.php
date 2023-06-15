<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApiCode extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'customer_id';
    public $timestamps = false;
}
