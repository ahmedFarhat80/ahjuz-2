<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.Customer.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => 'customer', 'sanctum']);
Broadcast::channel('App.Models.Owner.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => 'owner']);
Broadcast::channel('App.Models.Admin.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => 'admin']);
