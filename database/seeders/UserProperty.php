<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Owner;
use App\Models\Customer;
use App\Models\Property;
use App\Models\PropertyImg;
use App\Models\PropertyAddress;
use Illuminate\Database\Seeder;

class UserProperty extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory(55)->create();
        $owners = Owner::factory(25)->create();
        // Admin::factory(25)->create();

        $owners->each(fn($v) => Property::factory(rand(1, 2))->create(['owner_id' => $v->id]));

        $properties = Property::pluck('id');
        $properties->each(fn($id) => PropertyAddress::factory()->create(['property_id' => $id]));        
        $properties->each(fn($id) => PropertyImg::factory(rand(5, 7))->create(['property_id' => $id]));        
    }
}
