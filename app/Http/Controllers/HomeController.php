<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Helper\Menu;
use App\Model\Level;
use App\User;
use App\Model\Category;
use App\Model\Article;
use App\Http\Resources\ArticleBlogCollection;

class HomeController extends Controller{

    private $Menu = null;
    private $visibility_id = [1,2,3];

    private function buildMenu($Category, $route = false){

        $Menu =  new Menu;
        $Category = $Category->where('isMenu', 1);

        foreach ($Category as $category){

            if($category->articles()->count() > 0){

                if($route){
                    $url = route('openCategory', $category->name);
                }else{
                    $url = "#$category->name";
                }
    
                $Menu->add([
                    'name' => $category->name,
                    'url' => $url,
                    'icon' => $category->icon,
                    'color' => $category->color,
                ]);

            }
        }
        
        $this->Menu = $Menu;
        return $Menu->build();
    }

    private function getCategorys(){

        $Category = new Category;
        if(Auth::id()) $this->visibility_id = [1,2,3,5];

        return $Category
                ->where('id', '<>', 1)
                ->whereIn('visibility_id', $this->visibility_id)
                    ->orderBy('id')->get();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Category $Category, Article $Article){

        $categorys = $this->getCategorys();

        $ArticleBlogCollection = new ArticleBlogCollection([]);

        $breakingnewsCategory = $categorys->where('isMenu', 1);
                
        $breakingnews = $ArticleBlogCollection->cols(
                    $Article
                        ->whereIn('category_id', $breakingnewsCategory->pluck('id'))
                        ->whereIn('visibility_id', $this->visibility_id)
                            ->orderBy('id', 'desc')->limit(3)->get()
                    );

        $topnews = $ArticleBlogCollection->cols(
                    $Article
                        ->whereIn('category_id', $breakingnewsCategory->pluck('id'))
                        ->whereIn('visibility_id', $this->visibility_id)
                        ->whereNotIn('id', $breakingnews->pluck('id'))
                            ->orderBy('view', 'desc')->limit(3)->get()
                    );

        $articles = $ArticleBlogCollection->group(
            $Article
                ->whereIn('category_id', $categorys->pluck('id'))
                ->whereIn('visibility_id', $this->visibility_id)
                ->whereNotIn('id', $breakingnews->pluck('id'))
                ->whereNotIn('id', $topnews->pluck('id'))
                    
                        ->orderBy('category_id')
                            ->get()
                                ->groupBy('category_id')
            );

            // dd($articles);

        $menu = $this->buildMenu($categorys);
        return view('home', compact('menu', 'breakingnews', 'topnews', 'articles'));
    }

    public function category($categoryName, Category $Category, Article $Article){

        $categorys = $this->getCategorys();

        $categoryName = strtolower($categoryName);

        $category = $Category->select('id', 'name')
                        ->whereIn('visibility_id', $this->visibility_id)
                        ->where( function ($query) use ($categoryName){

                            $query->where('id', $categoryName)
                                  ->orWhere('name', $categoryName);

                        })->first();

        if(!isset($category) && !Auth::check()){

            return redirect()->route('login')->with(['redirect' => route('openCategory', $categoryName)])->withErrors(['message' => 'Login is required.']);
            
        }else if(!isset($category)){

            return redirect()->route('home')->withErrors(['message' => 'Invalid request.']);
        }

        $ArticleBlogCollection = new ArticleBlogCollection([]);

        $articles = $ArticleBlogCollection->process(
            $Article
                ->where('category_id', $category->id)
                ->whereIn('visibility_id', $this->visibility_id) 
                    ->orderBy('id', 'desc')->paginate(10)
            );

            $this->buildMenu($categorys, true);
            $this->Menu->setActive($category->name);
            $menu = $this->Menu->build();

            $title = ucfirst($category->name);
            return view('category', compact('title','menu', 'category','articles'));
    }

    public function byUser($userName, User $User, Article $Article){

        $user = $User->where('name', $userName)->first();

        if(!$user)
            return redirect()->route('route')->withErrors(['message' => 'Invalid request.']);


        $categorys = $this->getCategorys();
        $ArticleBlogCollection = new ArticleBlogCollection([]);

        $articles = $ArticleBlogCollection->process(
            $Article
                ->where('user_id', $user->id)
                ->whereIn('visibility_id', $this->visibility_id) 
                    ->orderBy('id', 'desc')->paginate(10)
            );

        $this->buildMenu($categorys, true);
        $menu = $this->Menu->build();        

        $title = ucfirst($userName);
        return view('category', compact('title', 'menu', 'articles'));
    }

    public function article($id, Article $Article, Category $Category){
            
        $errorMensage = 'Article not found.';        

        $article = $Article
                        // ->whereIn('visibility_id', $this->visibility_id)
                        ->where(function ($query) use ($id) {

                            $query->where('id', $id)
                                  ->orWhere('title', $id);
                        })
                            ->first();
        
        if(!$article)
            return redirect()
                    ->route('home')
                        ->withError(['message' => 'Invalid request.']);             

        if(!array_search($article->visibility_id, $this->visibility_id) && !Auth::check())

            return redirect()
                    ->route('login')
                    ->with(['redirect' => route('openArticle', $id)])
                    ->withErrors(['message' => 'Login is required.']);

        $category = $article->category()->first();                                                

        if(!Auth::check() && $article->visibility_id == 3){

            return redirect()
                    ->route('login')
                    ->with(['redirect' => route('openArticle', $id)])
                    ->withErrors(['message' => 'Login is required.']);

        }else if(!Auth::check() && $article->visibility_id == 1 && $category->visibility_id == 3)

            return redirect()
                    ->route('login')
                    ->with(['redirect' => route('openArticle', $id)])
                    ->withErrors(['message' => 'Login is required.']);

        //SEE TOO
            $seeToo = $Article->select('id', 'title')
                                ->where('id', '<>', $article->id)
                                ->where('category_id', $article->category_id)
                                    ->inRandomOrder()->limit(3)->get();
                                
        //ADD VIEW
        $article->view++;
        $article->save();

        $categorys = $this->getCategorys();
        $this->buildMenu($categorys, true);
        $this->Menu->setActive($category->name);
        $menu = $this->Menu->build();

        $title = ucfirst($category['name'])." | ".ucfirst($article['title']);
        return view('article', compact('menu', 'title','article', 'seeToo', 'category')); 
    }

    public function search(request $request, Category $Category,Article $Article, Level $Level, User $User){

        $search = $request->query()['search'];
        $search = str_replace(' ', '%', $search);

        $categorys = $Category
                        ->whereIn('visibility_id', $this->visibility_id)
                        ->where('name', 'like', "%$search%")
                            ->get();

        $level = $Level
                    ->select('id')
                        ->where('permission', '>=', 770)
                            ->get();

        $users = $User
                    ->select('name')
                        ->whereIn('level_id', $level->pluck('id'))
                        ->where('name', 'like', "%$search%")
                            ->get();                            

        $ArticleBlogCollection = new ArticleBlogCollection([]);
        
        $articles = $ArticleBlogCollection->process(
                    $Article
                        ->whereIn('visibility_id', $this->visibility_id)
                        ->where('title', 'like',"%$search%")
                        // ->orWhere('content', "%$search%")
                            ->paginate(10)
                    );

        $search = $request->query()['search'];

        $categorysMenu = $this->getCategorys();
        $this->buildMenu($categorysMenu);                    
        $this->Menu->setActive('Search');
        $menu = $this->Menu->build();
        return view('search', compact('menu', 'search', 'categorys', 'users', 'articles'));        
    }
}
