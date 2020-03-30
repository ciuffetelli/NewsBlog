<?php

use Illuminate\Database\Seeder;

class VisibilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        DB::table('sis_visibility')->insert(['name' => 'by category']);                             //1
        DB::table('sis_visibility')->insert(['name' => 'public']);                                  //2
        DB::table('sis_visibility')->insert(['name' => 'partially public']);                        //3
        DB::table('sis_visibility')->insert(['name' => 'unlisted']);                                //4
        DB::table('sis_visibility')->insert(['name' => 'private']);                                 //5
        DB::table('sis_visibility')->insert(['name' => 'not published']);                           //6
        

    }
}