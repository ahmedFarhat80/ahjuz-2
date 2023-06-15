<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('governorates')->insert([
            [
                'id'=> 1,
                'name' => 'العاصمة',
            ],
            [
                'id'=> 2,
                'name' => 'محافظة حولي',
            ],
            [
                'id'=> 3,
                'name' => 'محافظة الفروانية',
            ],
            [
                'id'=> 4,
                'name' => 'محافظة الأحمدي',
            ],
            [
                'id'=> 5,
                'name' => 'محافظة الجهراء',
            ],
            [
                'id'=> 6,
                'name' => 'محافظة مبارك الكبير',
            ],
        ]);
    }
}
