<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            //Role List
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            //User list
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            //Permission list
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            
         ];
      
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roles =[
            'Admin',
            'Staff',
            'User',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }


        $user =[
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => date('Y-m-d h:i:s'),
        ];

        $userd = User::create($user);
        $userd->assignRole('Admin');


        // permission assign
        $rolepermission = 
        [
            ['permission_id' => 1,  'role_id' => 1],
            ['permission_id' => 2,  'role_id' => 1],
            ['permission_id' => 3,  'role_id' => 1],
            ['permission_id' => 4,  'role_id' => 1],
            ['permission_id' => 5,  'role_id' => 1],
            ['permission_id' => 6,  'role_id' => 1],
            ['permission_id' => 7,  'role_id' => 1],
            ['permission_id' => 8,  'role_id' => 1],
            ['permission_id' => 9,  'role_id' => 1],
            ['permission_id' => 10, 'role_id' => 1],
            ['permission_id' => 11, 'role_id' => 1],
            ['permission_id' => 12, 'role_id' => 1],
        ];
        foreach($rolepermission as $role)
        {
            \DB::table('role_has_permissions')->insert($role);
        }
    }
}
