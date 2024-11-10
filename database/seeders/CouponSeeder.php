<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'title' => 'Get OFF use this code',
                'code' => 'abc1231',
                'type' => 'fixed',
                'value' => '300',
                'status' => 'active',
                'Coupen_Allowed' => 'active'
            ),
            array(
                'title' => 'Get OFF use this code',
                'code' => '111111',
                'type' => 'percent',
                'value' => '10',
                'status' => 'active',
                'Coupen_Allowed' => 'active'
            ),
        );

        DB::table('coupons')->insert($data);
    }
}
