<?php

namespace Database\Seeders;

use App\Enums\BookingStatus;
use App\Enums\CouponType;
use Carbon\Carbon;
use Faker\Factory;
use App\Models\Owner;
use App\Models\Coupon;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Property;
use App\Enums\PaymentMethod;
use Faker\Provider\ar_SA\Text;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookingCount =   4000;
        
        $properties = Property::all();
        $customers = Customer::all();
        $coupons = Coupon::all();

        $faker = Factory::create(); 
        $faker->addProvider(new Text($faker));

        for ($i=0; $i < $bookingCount; $i++) { 

            $property       =   $properties->random();
            $starts_at      =   $faker->dateTimeBetween('-2 month', '2 month')->format('Y-m-d');
            $ends_at        =   Carbon::parse($starts_at)->addDays($faker->numberBetween(1, 5))->format('Y-m-d');

            if (!$property->isAvailable($starts_at, $ends_at)) {
                continue;
            }

            if ($faker->boolean(30)) {
                Booking::create([
                    'is_foreign'        => 1,
                    'property_id'       => $property->id,
                    'details'           => $faker->realText(50),
                    'starts_at'         => $starts_at,
                    'ends_at'           => $ends_at,
                ]);    
            } else {
                // $unit_price     =   $faker->numberBetween(10, 50) * $faker->randomElement([10,50]);
                $days           =   Carbon::parse($starts_at)->diffInDays(Carbon::parse($ends_at));
                $average_price  =   $property->average_price(Carbon::parse($starts_at), Carbon::parse($ends_at), $days);
                $subtotal_price =   $average_price * $days;
                $insurance      =   $property->insurance_price;
                $coupon         =   $faker->boolean(25) ? $coupons->random() : null;
                $discount       =   $coupon ? $coupon->getDiscount($subtotal_price) : null;
                $total_price    =   $subtotal_price + $insurance - $discount;
                $commission     =   ($subtotal_price - $discount) * 0.1;

                Booking::create([
                    'property_id'       => $property->id,
                    'customer_id'       => $customers->random()->id,
                    'coupon_id'         => $coupon->id ?? null,
                    'payment_method'    => PaymentMethod::getRandomValue(),

                    'subtotal_price'    => $subtotal_price,
                    'insurance'         => $insurance,
                    'discount'          => $discount,
                    'total_price'       => $total_price,
                    'commission'        => $commission,
                    'revenue'           => $total_price - $commission,

                    'starts_at'         => $starts_at,
                    'ends_at'           => $ends_at,

                    'status'            => $faker->boolean(90) ? BookingStatus::Paid : BookingStatus::Canceled,
                ]);
            }

        }
    }
}