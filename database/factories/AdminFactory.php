<?php

namespace Database\Factories;

use Faker\Provider\ar_SA\Person;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Person($this->faker));
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'phone'             => $this->faker->unique()->randomNumber(8, true),
            'password'          => 111,
            'remember_token'    => Str::random(10),
        ];
    }
}

