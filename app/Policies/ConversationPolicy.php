<?php

namespace App\Policies;

use App\Models\Owner;
use App\Models\Customer;
use App\Models\Property;
use App\Models\Conversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    public function messageOwner(Customer $customer, Conversation $conversation)
    {
        return $customer->id == $conversation->customer_id && $customer->bookings()->where('property_id', $conversation->property_id)->exists();
    }

    public function messageCustomer(Owner $owner, Conversation $conversation)
    {
        return $owner->id == $conversation->property->owner_id && $conversation->property->bookings()->where('customer_id', $conversation->customer_id)->exists();
    }
}
