<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'description' => "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. sed ut perspiciatis unde sunt in culpa qui officia deserunt mollit anim id est laborum. sed ut perspiciatis unde omnis iste natus error sit voluptatem Excepteu sunt in culpa qui officia deserunt mollit anim id est laborum. sed ut perspiciatis Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. sed ut perspi deserunt mollit anim id est laborum. sed ut perspi.",
            'short_des' => "Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.",
            'photo' => "image.jpg",
            'logo' => 'logo.jpg',
            'address' => "India",
            'email' => "awish@gmail.com",
            'phone' => "+91 7408216946",
            'boffer' => "Get 10% Offer",
            'cartcolor' => "red",
            'categorytext' => "Category",
            'concerntext' => "Concern",
            'brandtext' => "Banner",
            'seo' => "<meta/>",
            'analytics' => "<script></script>",

        );
        DB::table('settings')->insert($data);
    }
}
