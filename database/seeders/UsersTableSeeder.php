<?php

namespace Database\Seeders;

use App\Http\Middleware\Admin;
use App\Models\Admin as ModelsAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data = array(
        //     array(
        //         'name' => 'Admin',
        //         'email' => 'admin@gmail.com',
        //         'password' => Hash::make('admin@123'),
        //         'role' => 'admin',
        //         'status' => 'active'
        //     ),
        //     array(
        //         'name' => 'User',
        //         'email' => 'user@gmail.com',
        //         'password' => Hash::make('user@123'),
        //         'role' => 'user',
        //         'status' => 'active'
        //     ),
        // );
        $user = ModelsAdmin::create([
            'name' => 'Admin',
            'email' => 'admin123@gmail.com',
            'password' => Hash::make('admin@123'),
            'mobile' => '8887983006',
            'role' => 'admin',
            'status' => 'active'

        ]);

        //ssss    $role = Role::create(['name' => 'admin']);

        //    $permissions = Permission::pluck('id','id')->all();

        //      $role->syncPermissions($permissions);

        //$user->assignRole([$role->id]);


    }
}
