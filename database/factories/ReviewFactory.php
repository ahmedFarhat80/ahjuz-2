<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Property;
use Faker\Provider\ar_SA\Text;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Text($this->faker));

        return [
            'customer_id' => Customer::factory(),
            'property_id' => Property::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'body' => $this->faker->optional(0.60, null)->realText(),
        ];
    }
}