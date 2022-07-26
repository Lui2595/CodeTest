<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    
    {
        DB::table('users')->insert([
            'first_name' => "Admin",
            'last_name' => "User",
            'user_type'=> "Admin",
            'email' => 'admin@gmail.com',
            'password' => Hash::make('pass'),
        ]);
        DB::table('users')->insert([
            'first_name' => "Supervisor",
            'last_name' => "User",
            'user_type'=> "Supervisor",
            'email' => 'supervisor@gmail.com',
            'password' => Hash::make('pass'),
        ]);
        DB::table('users')->insert([
            'first_name' => "Blogger",
            'last_name' => "User",
            'user_type'=> "Blogger",
            'email' => 'blogger@gmail.com',
            'password' => Hash::make('pass'),
        ]);
    }
}
