<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Article;
use App\Model\Category;
use App\Model\Layout;
use App\Model\Visibility;

use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {

    // $faker = Faker\Factory::create();
    $faker->addProvider(new BlogArticleFaker\FakerProvider($faker));

    // $layout_id = Layout::all()->random()->id;
    // $visibility_id = Visibility::all()->random()->id;
    // $content = $faker->articleContent;

    // if($layout_id > 2 || $visibility_id == 3){
    //     $content = $faker->articleContent
    // }else{

    // }

    $layout_id = Layout::all()->random()->id;
    if($layout_id === 6) $layout_id = 1;

    return [
        'title' => $faker->articleTitle,
        'category_id' => Category::all()->random()->id,
        'layout_id' =>$layout_id,
        //Layout::all()->random()->id,
        'visibility_id' => Visibility::all()->random()->id,
        //Visibility::all()->random()->id,
        // 'content' => $faker->articleContentMarkdown,
        'content' => $faker->articleContent,
        'view' => rand(0, 999),
        'user_id' => 1,
        

    ];
});
