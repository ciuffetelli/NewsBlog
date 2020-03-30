<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Helper\Menu;
use App\Model\Category;
use App\Model\Article;
use App\Http\Resources\ArticleBlogCollection;

class WelcomeController extends Controller{

    private $Menu = null;

    public function buildMenu($Category){

        $Menu =  new Menu;

        foreach ($Category as $category){
            $Menu->add([
                'name' => $category->name,
                'url' => "#$category->name",
                'icon' => $category->icon,
                'color' => $category->color,
            ]);
        }

        if(auth()->user()){
            $Menu->setHome(route('home'));
        }else{
            $Menu->setHome(route('welcome'));
        }        
        
        $this->Menu = $Menu;
        return $Menu->build();
    }    
    
    public function index(Category $Category, Article $Article){

        $categorys = $Category
                        ->where('id', '<>', 1)
                        ->whereIn('visibility_id', [2,3])
                        ->orderBy('id')->get();

        $ArticleBlogCollection = new ArticleBlogCollection([]);
        
        $breakingnews = $ArticleBlogCollection->small(
                    $Article
                        ->whereIn('category_id', $categorys->pluck('id'))
                        ->whereIn('visibility_id', [1,2,3])
                            ->orderBy('id', 'desc')->limit(3)->get()
                    );

        $topnews = $ArticleBlogCollection->small(
                    $Article
                        ->whereIn('category_id', $categorys->pluck('id'))
                        ->whereIn('visibility_id', [1,2,3])
                        ->whereNotIn('id', $breakingnews->pluck('id'))
                            ->orderBy('view', 'desc')->limit(3)->get()
                    );

        $articles = [];

        foreach($categorys as $category){
            $articleData = $ArticleBlogCollection->process(
                $Article
                    ->where('category_id', '<>', $category['id'])
                    ->whereIn('visibility_id', [1,2,3])
                    ->whereNotIn('id', $breakingnews->pluck('id'))
                    ->whereNotIn('id', $topnews->pluck('id')) 
                        ->orderBy('id')->limit(5)->get()
                );

            array_push($articles, json_encode([
                'category' => $category->name,
                'color'    => $category->color,
                'layout'   => $category->layout,
                'data'     => $articleData
            ]));
        }

        $menu = $this->buildMenu($categorys);
        return view('welcome', compact('menu', 'breakingnews', 'topnews', 'articles'));
    }
}
