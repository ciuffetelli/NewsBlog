<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){      
        DB::table('categorys')->insert([
            'name'    => 'no category',
            'color' =>  '#000',
            'user_id' => 1,
            'layout_id' => 2,
            'protect' => true
        ]);

        //DATA EXAMPLE
        DB::table('categorys')->insert([
            'name'  => 'news',
            'color' => '#Ce0000',
            'icon'  => 'fab fa-neos',
            'visibility_id' => 3,
            'layout_id' => 2,
            'user_id' => 1
        ]);

        DB::table('categorys')->insert([
            'name'  => 'sports',
            'color' => '#006393',
            'icon'  => 'fab fa-stripe-s',
            'visibility_id' => 2,
            'layout_id' => 2,
            'user_id' => 1
        ]);        

        DB::table('categorys')->insert([
            'name'  => 'commentator',
            'color' => '#008080',
            'icon'  => 'fab fa-cuttlefish',
            'visibility_id' => 5,
            'layout_id' => 2,
            'user_id' => 1
        ]);
        
    }
}
