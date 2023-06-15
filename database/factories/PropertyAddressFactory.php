<?php

namespace Database\Factories;

use App\Models\Governorate;
use App\Models\Property;
use App\Models\Region;
use Faker\Provider\ar_SA\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Address($this->faker));

        $governorate_id = Governorate::pluck('id')->random();
        $regions_id = Region::where('governorate_id', $governorate_id)->pluck('id')->random();

        return [
            'property_id'               => Property::factory(),
            'governorate_id'            => $governorate_id,
            'region_id'                => $regions_id,
            'details'                   => $this->faker->streetName(),
            'latitude'                 => $this->faker->latitude(29, 29.4),
            'longitude'                 => $this->faker->longitude(47.95, 48.1),
        ];
    }
}
