<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('users')->insert([
            'name'     => 'Daily News',
            'email'    => 'admin@dailynews.com',
            'password' => Hash::make(102030),
            'level_id' => 3
        ]);  
    }
}
