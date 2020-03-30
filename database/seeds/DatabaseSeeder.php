<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){

        //sis
        $this->call(LevelTableSeeder::class);        

        //admin
        $this->call(UserTableSeeder::class);        

        //sis table
        $this->call(VisibilityTableSeeder::class);
        $this->call(LayoutTableSeeder::class);

        //Data Sample
        $this->call(CategoryTableSeeder::class);

        //factory
        factory(App\Model\Article::class, 50)->create();
    }
}
