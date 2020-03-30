<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Helper\Menu;
use App\Model\Category;

class HelpController extends Controller{

    private $Menu = null;

    function __construct(){
        $this->middleware('auth');
    }

    private function buildMenu(){

        $Menu = new Menu([[
            'name' => 'Articles',
            'url'  => route('article'),
            'icon' => 'fas fa-newspaper'
        ],[
            'name' => 'Categorys',
            'url'  => route('category'),
            'icon' => 'fas fa-book'                
        ],[
            'name' => 'help',
            'url' => route('help'),
            'icon' => 'fas fa-question-circle',
        ]]);
        
        // $Category = new Category;
        // $categorys = $Category
        //                 ->where('id', '<>', 1)
        //                 ->where('isMenu', 1)
        //                 ->whereIn('visibility_id', [2,3,5])
        //                     ->orderBy('id')->get();         

        // $home = route('home');
        // foreach ($categorys as $category){

        //     $Menu->add([
        //         'name' => $category->name,
        //         'url' => "$home/view/$category->name",
        //         'icon' => $category->icon,
        //         'color' => $category->color,
        //     ]);
        // }

        $Menu->setActive('help');
        $this->Menu = $Menu;
        return $this->Menu->build();
    }    

    
    
    public function index(){

        // if(!Auth::User()) return redirect()->route('login')->withErrors(['message' => 'Login is required.']);
        

        $title = 'Help';
        $menu = $this->buildMenu();
        return view('help.home', compact('title', 'menu'));
    }
}
