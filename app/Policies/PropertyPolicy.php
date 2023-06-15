<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\Owner;
use App\Models\Property;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyPolicy
{
    use HandlesAuthorization;

    public function manage(Owner $owner, Property $property) 
    {
        return $owner->id === $property->owner_id;
    }

    public function messageOwner(Customer $auth_customer, Property $property, Customer $customer) 
    {
        return $auth_customer->id == $customer->id && $customer->bookings()->where('property_id', $property->id)->exists();
    }

    public function messageCustomer(Owner $owner, Property $property, Customer $customer)
    {
        return $owner->id == $property->owner_id && $property->bookings()->where('customer_id', $customer->id)->exists();
    }
}
