<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Javed Ur Rehman', 
            'email' => 'javed@allphptricks.com',
            'mobile' => '998877665544',

            'password' => Hash::make('javed1234')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Syed Ahsan Kamal', 
            'email' => 'ahsan@allphptricks.com',
            'mobile' => '998877665599',
            'password' => Hash::make('ahsan1234')
        ]);
        $admin->assignRole('Admin');

        // Creating Product Manager User
        $branch = User::create([
            'name' => 'Abdul Muqeet', 
            'email' => 'muqeet@allphptricks.com',
            'mobile' => '998877665545',
            'password' => Hash::make('muqeet1234')
        ]);
        $branch->assignRole('branch');
    }
}