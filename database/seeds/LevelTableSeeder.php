<?php

use Illuminate\Database\Seeder;

class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('sis_level')->insert([
            'name' => 'user',
            'permission' => '444'
        ]);        
        DB::table('sis_level')->insert([
            'name' => 'publisher',
            'permission' => '770'
        ]);        
        DB::table('sis_level')->insert([
            'name' => 'admin',
            'permission' => '777'
        ]);                
        // DB::table('sis_level')->insert([
        //     'name' => 'guest',
        //     'permission' => '000'
        // ]);
    }
}
