<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Property;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $customers = Customer::all();
        $properties = Property::pluck('id');

        $this->randCustomerProperty(Review::class, $customers, $properties,  1000);
    }

    private function randCustomerProperty($class, $customers, $properties, $count)
    {

        $customerProperty = [];
        $i = 0;

        while ($i++ < $count) {
            $customer = $customers->random();
            $property_id = $properties->random();

            $canReview = $customer->bookings()->canBeReviewed($property_id);

            $customerProperty[] = $customer->id . $property_id;

            if (!$canReview || !checkArrayElementsAreUnique($customerProperty)) {
                array_pop($customerProperty);
                continue;
            }

            $class::factory()->create([
                'customer_id' => $customer->id,
                'property_id' => $property_id
            ]);
        }
    }
}
