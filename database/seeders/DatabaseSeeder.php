<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GovernorateSeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(UserProperty::class);
        $this->call(CouponSeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(SiteSettingSeeder::class);

        Admin::create([
            'name' => 'admin',
            'password' => bcrypt(111),
            'email' => '123@gmail.com'
        ]);

    }
}
