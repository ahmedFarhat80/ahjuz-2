<?php

namespace Database\Seeders;

use App\Enums\CouponStatus;
use App\Models\Coupon;
use App\Enums\CouponType;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = ['created_at'=> now(), 'updated_at'=> now()];

        Coupon::insert(array_map(fn($v) => $v + $time,
            [
                [ 
                    'code' => '000NEW',
                    'type' => CouponType::Percent,
                    'value' => 10,
                    'status' => CouponStatus::Active,
                    'max_use_count' => 5,
                    'starts_at' => now(),
                    'ends_at' => now()->addYear()
                ],
                [ 
                    'code' => '000GOLD',
                    'type' => CouponType::Fixed,
                    'value' => 50,
                    'status' => CouponStatus::Active,
                    'max_use_count' => 5,
                    'starts_at' => now(),
                    'ends_at' => now()->addYear()
                ],
            ]   
        ));
    }
}

