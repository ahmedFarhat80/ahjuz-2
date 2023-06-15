<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Owner;
use App\Enums\PropertyFor;
use App\Enums\PropertyType;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Enums\PropertyStatus;
use Faker\Provider\ar_SA\Text;
use App\Enums\PropertyIsActive;
use App\Enums\PropertyIsSpecial;
use Faker\Provider\ar_SA\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Person($this->faker));
        $this->faker->addProvider(new Text($this->faker));

        $opens_at   = $this->faker->time('H:i');
        $type       = PropertyType::getRandomInstance();
        $name       = $type->description . ' ' . $this->faker->unique()->lastName();
        $price      = $this->faker->numberBetween(10, 50) * 10;
        // $cover = $this->faker->image(storage_path('app\public\media\properties\covers'), 150, 150);

        return [
            'name'              => $name,
            'slug'              => Str::slug($name , '-', null),
            'owner_id'          => Owner::factory(),

            'day_price'         => $price,
            'thursday_price'    => $price + 100,
            'friday_price'      => $price + 200,
            'insurance_price'   => $price * 0.3,

            'type'              => $type->value,
            'description'       => $this->faker->realText(),
            'area'              => $this->faker->numberBetween(10, 100) * 10,
            'for'               => PropertyFor::getRandomValue(),
            'opens_at'          => $opens_at,
            'closes_at'         => Carbon::parse($opens_at)->addHours(12)->isoFormat('HH:mm'),

            'is_special'        => $this->faker->boolean(25) ? PropertyIsSpecial::Yes : PropertyIsSpecial::No,
            'is_active'         => $this->faker->boolean(75) ? PropertyIsActive::Yes : PropertyIsActive::No,
            'status'            => $this->faker->boolean(50) ? PropertyStatus::Accepted : $this->faker->randomElement(Arr::except(PropertyStatus::getValues(), PropertyStatus::Accepted)),
            // 'cover'             => substr($cover, strpos($cover, 'media')),
        ];
    }
}