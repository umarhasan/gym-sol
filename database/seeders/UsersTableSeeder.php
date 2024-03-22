<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Generate 100 user entries using the factory
        User::factory(9993)->create();

        // Assign role ID 3 to all users
        $users = User::all();
        foreach ($users as $user) {
            $user->assignRole("Member");
        }
    }

}
