<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

use App\Helper\Menu;

class PanelController extends Controller{

    private $Menu = null;

    public function index(){

        $user_level = Auth::User()->level()->first();

        if($user_level->permission > 770){

            $this->Menu = new Menu([
                [
                    'name' => 'Write',
                    'url'  => route('newArticle'),
                    'icon' => 'fas fa-pen'
                ],[
                    'name' => 'Articles',
                    'url'  => route('article'),
                    'icon' => 'fas fa-newspaper'
                ],[
                    'name' => 'Categorys',
                    'url'  => route('category'),
                    'icon' => 'fas fa-book'                
                ]
            ]);            

            $this->Menu->setActive('panel');
            $menu = $this->Menu->build();
            
        }else{
            $menu = [];
        }

        return view('Panel\home', compact('menu', 'user_level'));
    }
}
