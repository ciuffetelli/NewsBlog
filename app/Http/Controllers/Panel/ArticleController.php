<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Helper\Menu;
use App\Model\Layout;
use App\Model\Visibility;
use App\Model\Category;
use App\Model\Article;
use App\Http\Resources\ArticleCollection;

class ArticleController extends Controller{

    private $Menu = null;

    function __construct(){

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
            ],[
                'name' => 'Help',
                'url'  => route('help'),
                'icon' => 'fas fa-question-circle'                
            ]
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */    
    protected function validator(array $data, $id = null){
        return Validator::make($data, [
            'title'         => ['required', 'string', 'max:255', 'min:4'],
            'category_id'   => ['required', 'integer', "exists:categorys,id"],
            'layout_id'    => ['required', 'integer', 'exists:sis_layout,id'],
            'visibility_id' => ['required', 'integer', 'exists:sis_visibility,id'],
            'content'   => ['required']
        ]);
    }    
    
    private function buildMenu($Category, $route = false){

        $Menu =  new Menu;
        $Category = $Category->where('isMenu', 1);

        foreach ($Category as $category){

            if($route){
                $url = route('home')."/view/$category->name";
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
        
        $this->Menu = $Menu;
        return $Menu->build();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Article $Article){

        $data = new ArticleCollection($Article->select('id','title', 'category_id', 'view', 'layout_id', 'visibility_id', 'user_id')
                    ->orderBy('id', 'desc')
                    ->paginate(20));
    
        $route = json_encode([
            'view' => route('viewArticle'),
            'edit' => route('newArticle'),
            'delete' => route('deleteArticle'),
        ]);

        $data = json_encode($data);

        $this->Menu->setActive('Articles');
        $menu = $this->Menu->build();
        return view('Panel\articles', compact('menu', 'data', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $Category, Visibility $Visibility, Layout $Layout){

        $categorys = json_encode($Category->select('id as value', 'name')->get());
        $visibility = json_encode($Visibility->select('id as value', 'name')->get());
        $layout = json_encode($Layout->select('id as value', 'name')->get());

        $data = !empty(session()->get('data'))? session()->get('data') : [];

        $this->Menu->setActive('Write');
        $menu = $this->Menu->build();
        return view('Panel\newArticle', compact('menu', 'data', 'categorys', 'visibility', 'layout'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Article $Article, Category $Category){

        $data = $request->except('_token');

        $validator = $this->validator($data);

        if(!$validator->fails()){

            $data['user_id'] = Auth::id();
            $data['title'] = strtolower($data['title']);
            // $data['content'] = json_encode(explode('>', $data['content']));

            if($Article->updateOrInsert($data)){
                return redirect()->route('article')->with(['success' => 'Aticle was saved.']);
            }else{
                $errors['message'] = 'error on save';
            }            

        }else{
            $errors = $validator;
        }

        return redirect()->route('newArticle')->with(['data' => $data])->withErrors($errors);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Article $Article, Category $Category){

        $visibility_id = [1,2,3,4];

        if(Auth::check()) $visibility_id = [1,2,3,4,5];
            
            $errorMensage = 'Article not found.';
        

        $article = $Article
                        ->whereIn('visibility_id', $visibility_id)
                        ->where(function ($query) use ($id) {

                            $query->where('id', $id)
                                  ->orWhere('title', $id);
                        })
                            ->first();

        if(!$article && !Auth::check())

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

                    
        $categoryForMenu = $Category
                            ->where('id', '<>', 1)
                            ->whereIn('visibility_id', $visibility_id)
                                ->orderBy('id')->get();

        //SEE TOO
            $seeToo = $Article->select('id', 'title')
                                ->where('id', '<>', $article->id)
                                ->where('category_id', $article->category_id)
                                    ->inRandomOrder()->limit(3)->get();
                                
        //ADD VIEW
        $article->view++;
        $article->save();

        $this->buildMenu($categoryForMenu, true);
        $this->Menu->setActive($category->name);
        $menu = $this->Menu->build();
        $title = ucfirst($category['name'])." | ".ucfirst($article['title']);
        return view('article', compact('menu', 'title','article', 'seeToo', 'category')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Article $Article, Category $Category, Visibility $Visibility, Layout $Layout){
        if(empty(session()->get('data'))) $data = $Article->find($id);

        if(!$data) return redirect()->route('newArticle');

        // $data['content'] = implode('>', json_decode($data['content']));
        $data['user_name'] = $data->user()->first()->name;

        $categorys = json_encode($Category->select('id as value', 'name')->get());
        $visibility = json_encode($Visibility->select('id as value', 'name')->get());
        $layout = json_encode($Layout->select('id as value', 'name')->get());

        $this->Menu->add([
            'name' => 'Edit',
            'url'  => '#',
            'icon' => 'fas fa-edit'
        ], 2);

        $this->Menu->remove(0);
        $this->Menu->setActive('Edit');
        $menu = $this->Menu->build();
        return view('Panel\newArticle', compact('menu', 'data', 'categorys', 'visibility', 'layout')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Article $Article){

        $data = $request->except('_token');

        $validator = $this->validator($data, $data['id']);
        
        if(!$validator->fails()){

            $data['title'] = strtolower($data['title']);
            // $data['content'] = json_encode(explode('>', $data['content']));

            $article = $Article->find($data['id']);

            if($article->update($data)){
                
                return redirect()->route('article')->with(['success' => 'Article was updated.']);

            }else{
                $errors['message'] = 'error on save';
            }

        }else{
            $errors = $validator;
        }

        return redirect()->route('newArticle')->with(['data' => $data])->withErrors($errors);        
    }

    public function destroyConfirm($id = null, Article $Article){
        if(empty($id)) return redirect()->route('article')->withErrors(['message' => 'invalid request.']);

        $article = $Article->find($id);

        if(!$article) return redirect()->route('article')->withErrors(['message' => 'invalid request.']);

        $action = route('deleteArticle');

        $this->Menu->setActive('Articles');
        $menu = $this->Menu->build();
        return view('deleteConfirm', compact('menu', 'action', 'id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request, Article $Article){

        $id = $request->input('id');

        if(!$id) return redirect()->route('article')->withErrors(['message' => 'invalid request.']);

        $article = $Article->find($id);

        if(!$article) return redirect()->route('article')->withErrors(['message' => 'invalid request.']);

        if(!$article->delete()){

            return redirect()->route('article')->withErrors(['message' => 'internal error.']);
            
        }

        return redirect()->route('article')->with(['success' => 'Category was deleted.']); 
    }

    public function api(Article $Article){
        $data = new ArticleCollection($Article->select('id','title', 'category_id', 'layout_id', 'visibility_id', 'user_id')
                    ->orderBy('id', 'desc')
                    ->paginate(20));


        return response()->json($data);
    }
}
