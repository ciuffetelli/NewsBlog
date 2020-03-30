<?php

use Illuminate\Database\Seeder;

class LayoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('sis_layout')->insert(['name' => 'by category']);         //1
        DB::table('sis_layout')->insert(['name' => 'general']);             //2
        DB::table('sis_layout')->insert(['name'    => 'cols-2']);           //3
        DB::table('sis_layout')->insert(['name'    => 'cols-3']);           //4
        DB::table('sis_layout')->insert(['name'    => 'cols-4']);           //5
        DB::table('sis_layout')->insert(['name'    => 'carousel']);         //6
    }
}
