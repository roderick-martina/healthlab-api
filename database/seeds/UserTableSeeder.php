<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'admin',
        ]);
        DB::table('users')->insert([
            'email' => 'healthlab@gmail.com',
            'password' => bcrypt('health'),
        ]);
        DB::table('users')->insert([
            'email' => 'guest@gmail.com',
            'password' => bcrypt('guestguest'),
        ]);
        DB::table('users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        // User::create([
        //     'name' => 'Roderick',
        //     'email' => str_random(10).'@gmail.com',
        //     'password' => bcrypt('pokemon'),
        // ]);

    }
}
