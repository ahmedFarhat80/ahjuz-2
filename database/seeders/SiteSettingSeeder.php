<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // SiteSetting::truncate();
        SiteSetting::insert(
            [
                'commission' => 10,
                'main_headline' => 'ستجد راحتك و متعتك مع احجز',
                'main_text' => 'لدينا أفصل الخدمات بسرعة فائقة و جميلة مع احجز',
                'mobile_headline' => 'يكنك تحميل تطبيق احجز الأن',
                'mobile_text' => 'أصبح تطبيق احجز متوفر الأن على أجهزة الأندرويد و الأيفون حمل و جرب الأن',
                'address' => 'هذا النص هو مثال لنص',
                'phone' => '+9650000000000',
                'whatsapp_1' => '9650000000000',
                'whatsapp_2' => '9650000000000',
                'footer_text' => 'لمزيد من الراحة وفر وقتك من خلال احجز من خلالنا الان فلدينا أفضل الأسعار للجميع',
                'about_text' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى',
                'email' => '111@mail.com',
    
                'play_store' => 'https://www.google.com/',
                'apple_store' => 'https://www.apple.com/',
                'facebook' => 'https://www.facebook.com/',
                'twitter' => 'https://www.twitter.com/',
                'instagram' => 'https://www.instagram.com/',
                'snapchat' => 'https://www.snapchat.com/',
                'youtube' => 'https://www.youtube.com/',
            ]
        );
    }
}
