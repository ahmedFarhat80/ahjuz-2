<?php

namespace Database\Factories;

use Faker\Provider\ar_SA\Address;
use Faker\Provider\ar_SA\Person;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Person($this->faker));
        $this->faker->addProvider(new Address($this->faker));
        return [
            'first_name'            => $this->faker->firstName(),
            'last_name'             => $this->faker->lastName(),
            'address'               => $this->faker->address(),
            'email'                 => $this->faker->unique()->safeEmail(),
            'phone'                 => $this->faker->unique()->randomNumber(8, true),
            'remember_token'        => Str::random(10),
        ];
    }

    //     /**
    //  * Indicate that the model's email address should be unverified.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Factories\Factory
    //  */
    // public function unverified()
    // {
    //     return $this->state(function (array $attributes) {
    //         return [
    //             'email_verified_at' => null,
    //         ];
    //     });
    // }

}
