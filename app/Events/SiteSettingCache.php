<?php

namespace App\Events;

use App\Models\SiteSetting;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SiteSettingCache
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        Cache::forget('settings');
        Cache::rememberForever('settings', function () {
            return SiteSetting::first();
        });
    }
}
