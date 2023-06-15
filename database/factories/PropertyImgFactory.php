<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyImg;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyImgFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $path = Storage::disk('public')->path(PropertyImg::STOREAGE);

        if(!File::exists($path)){
            File::makeDirectory($path, 0775, true);
        }
        
        $name = $this->faker->image($path, 974, 430);

        return [
            'property_id'   => Property::factory(),
            'name'          => str_replace('\\', '', substr($name, strpos($name, 'media'))),        
        ];
    }
}

