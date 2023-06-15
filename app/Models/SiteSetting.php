<?php

namespace App\Models;

use App\Events\SiteSettingCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteSetting extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'restrict_to_one_row';
    public $timestamps = false;

    const STOREAGE = 'media/site-settings/';

    protected $dispatchesEvents = [
        'created' => SiteSettingCache::class,
        'updated' => SiteSettingCache::class,
        'deleted' => SiteSettingCache::class,
    ];

    public function getHeroImgAttribute($value) 
    {
        return asset($value ? 'storage/'. $value : 'frontend/img/hero-back.png');
    }

    public function getAboutImgAttribute($value) 
    {
        return asset($value ? 'storage/'. $value : 'frontend/img/about.svg');
    }
    
    public function getSocialAttribute() 
    {
        return ['facebook', 'twitter', 'instagram', 'snapchat', 'youtube'];
    }
}
