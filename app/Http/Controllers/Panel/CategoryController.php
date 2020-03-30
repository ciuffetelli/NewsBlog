<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Helper\Menu;

use App\Model\Layout;
use App\Model\Visibility;

use App\Model\Category;
use App\Http\Resources\CategoryCollection;
use App\User;

class CategoryController extends Controller{

    public $Menu = '';

    function __construct(){
        $this->Menu = new Menu([
            [
                'name' => 'Articles',
                'url'  => route('article'),
                'icon' => 'fas fa-newspaper'
            ],[
                'name' => 'Categorys',
                'url'  => route('category'),
                'icon' => 'fas fa-book'
            ],[
                'name' => 'New Category',
                'url'  => route('newCategory'),
                'icon' => 'fas fa-pen-alt'
            ],[
                'name' => 'Help',
                'url'  => route('help'),
                'icon' => 'fas fa-question-circle'                
            ],
        ]);

        $this->Menu->setActive('Categorys');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */    
    protected function validator(array $data, $id = null){
        return Validator::make($data, [
            // 'name'  => 'required, string, max:255, min:4, unique:categorys',
            'name'      => ['required', 'string', 'max:255', 'min:4', "unique:categorys,id,$id"],
            'color'     => ['required', 'string'],
            'layout_id'    => ['required', 'integer', 'exists:sis_layout,id'],
            'visibility_id' => ['required', 'integer', 'exists:sis_visibility,id'],
        ]);
    }    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $Category){

        $data = new CategoryCollection(
            $Category
            ->select('id', 'name', 'icon', 'color', 'layout_id', 'visibility_id')
                ->where('protect', false)
                    ->paginate(20)
        );

        $route= json_encode([
            'view' => route('home').'/view',
            'edit' => route('newCategory'),
            'delete' => route('deleteCategory'),
        ]);

        $convert = json_encode([
            'icon' => '<i class=":value"></i>',
            'color' => '<div style="
                color: #fff; 
                text-align: center; 
                background: :value;
                ">:value</div>'
        ]);
        
        $data = json_encode($data);
        $success = !empty(session()->get('success'))? session()->get('success') : null;

        $menu = $this->Menu->build();
        return view('Panel\categorys', compact('menu', 'data', 'route', 'convert', 'success'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Layout $Layout, Visibility $Visibility){

        $layout = $Layout->select('id as value', 'name')->where('id', '>', 1)->get();
        $visibility = $Visibility->select('id as value', 'name')->where('id', '>', 1)->get();

        $data = !empty(session()->get('data'))? session()->get('data') : [];

        $this->Menu->setActive('New Category');
        $menu = $this->Menu->build();
        return view('Panel\newCategory', compact('menu', 'layout', 'visibility', 'data'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $Category){

        $data = $request->except('_token');

        $validator = $this->validator($data);
        
        if(!$validator->fails()){
            
            $data['user_id'] = Auth::id();
            $data['name'] = strtolower($data['name']);
            $data['isMenu'] = isset($data['isMenu'])? true : false;

            if($Category->updateOrInsert($data)){

                return redirect()->route('category')->with(['success' => 'category was saved.']);

            }else{
                $errors['message'] = 'error on save';
            }

        }else{
            $errors = $validator;
        }

        return redirect()->route('newCategory')->with(['data' => $data])->withErrors($errors);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Category $categorys
     * @return \Illuminate\Http\Response
     */
    public function show($id, Category $Category, User $user, Layout $Layout, Visibility $Visibility){

        if(empty(session()->get('data'))){
            $data = $Category
            ->where('protect', false)
            ->where('id', $id)
                ->first();
        }        

        if(!$data) return redirect()->route('newCategory');

        $data['user_name'] = $user->find($data->user_id)->name;

        $layout = $Layout->select('id as value', 'name')->where('id', '>', 1)->get();
        $visibility = $Visibility->select('id as value', 'name')->where('id', '>', 1)->get();     
        
        $this->Menu->add([
            'name' => 'Edit Category',
            'url'  => '#',
            'icon' => 'fas fa-edit'
        ], 2);

        $this->Menu->remove(3);
        $this->Menu->setActive('Edit Category');
        $menu = $this->Menu->build();

        return view('Panel\newCategory', compact('menu', 'data', 'layout', 'visibility'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Category $Category, User $user){

        $data = $request->except('_token');

        $validator = $this->validator($data, $data['id']);
        
        if(!$validator->fails()){

            $data['name'] = strtolower($data['name']);
            $data['isMenu'] = isset($data['isMenu'])? true : false;

            $dataCategory = $Category
                ->where('protect', false)
                ->where('id', $data['id'])
                    ->first();            

            if($dataCategory->update($data)){
                
                return redirect()->route('category')->with(['success' => 'Category was updated.']);

            }else{
                $errors['message'] = 'error on save';
            }

        }else{
            $errors = $validator;
        }

        return redirect()->route('newCategory')->with(['data' => $data])->withErrors($errors);
    }

    public function destroyConfirm($id = null, Category $Category){
        if(empty($id)) return redirect()->route('category')->withErrors(['message' => 'invalid request.']);

        $category = $Category
            ->where('protect', false)
            ->where('id', $id)
                ->first();

        if(!$category) return redirect()->route('category')->withErrors(['message' => 'invalid request.']);

        $action = route('deleteCategory');

        $menu = $this->Menu->build();
        return view('deleteConfirm', compact('menu', 'action', 'id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $Category){

        $id = $request->input('id');

        if(!$id) return redirect()->route('category')->withErrors(['message' => 'invalid request.']);

        $category = $Category
            ->where('protect', false)
            ->where('id', $id)
                ->first();

        if(!$category) return redirect()->route('category')->withErrors(['message' => 'invalid request.']);

        if(!$category->delete()){

            return redirect()->route('category')->withErrors(['message' => 'internal error.']);

        }

        return redirect()->route('category')->with(['success' => 'Category was deleted.']);
    }   

    public function api(Category $Category){

            $data = new CategoryCollection(
                $Category
                ->select('id', 'name', 'icon', 'color', 'layout_id', 'visibility_id')
                    ->where('protect', false)
                        ->paginate(20)
            );

            return response()->json($data);
    }
}
