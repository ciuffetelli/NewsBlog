<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helper\Menu;

use App\User;
use App\Http\Resources\UserCollection;

use App\Model\Level;

class UserController extends Controller{

    private $Menu = null;

    function __construct(){

        $this->Menu = new Menu([
            [
                'name' => 'user',
                'url'  => route('user'),
                'icon' => 'fas fa-users'
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

        $this->Menu->setActive('user');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */    
    protected function validator(array $data, $id = null){
        return Validator::make($data, [
            'name'         => ['required', 'string', 'max:255', 'min:4'],
            'email'   => ['required', 'email', "unique:users,id,$id"],
            'level_id' => ['required', 'integer', 'exists:sis_level,id'],
        ]);
    }      

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $User){

    $user = new UserCollection(
                    $User
                        ->select('id', 'name', 'email', 'created_at','level_id')
                        ->where('level_id', '<', Auth::User()->level_id)
                        ->orWhere('id', Auth::id())
                            ->paginate(20)
                );

        $user = json_encode($user);
        $userConvert = json_encode([
            'email' => '<span style="text-transform: lowercase;">:value</span>'
        ]);
        $userRoute = json_encode([
            'edit' => route('user'),
            'delete' => route('deleteUser')
        ]);

        $title = 'User';
        $menu = $this->Menu->build();
        return view('Panel.user', compact('menu', 'title', 'user', 'userConvert', 'userRoute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($email, User $User, Level $Level){

        $user = $User->where('email', $email)->first();

        if(!$user) return redirect()->route('home')->withErrors(['message' => 'Invalid request.']);

        if($email != Auth::User()->email && $user->level_id >= Auth::User()->level_id)
            return redirect()->route('home')->withErrors(['message' => 'unauthorized.']);

        if($email != Auth::User()->email){
            $editFull = false;
        }else{
            $editFull = true;
        }

        if(Auth::User()->level()->first()->permission >= 777 && $User->where('level_id', 1)->get()->count() > 1){

            $level = $Level->select('id as value', 'name')->get();

        }else{

            $level = $Level->select('id as value', 'name')->where('id', Auth::User()->level_id)->get();

        }

        $title = 'User | Edit';
        $menu = $this->Menu->build();
        return view('Panel.userEdit', compact('menu', 'title', 'user', 'editFull', 'level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $User){

        $data = $request->except('_token');
        $user = $User->find($data['id']);

        if($user->id != Auth::User()->id && $user->level_id >= Auth::User()->level_id)
            return redirect()->route('home')->withErrors(['message' => 'unauthorized.']);

            $validator = $this->validator($data, $data['id']);

            if(isset($data['password']) && $data['password'] != $data['password_confirmation']){
                return redirect()->back()->withErrors(['message' => 'password has not been confirmed']);
            }

        if(!$validator->fails()){

            $data['name'] = strtolower($data['name']);
            $data['email'] = strtolower($data['email']);
            if(!isset($data['password'])) $data['password'] = $user->password;

            if($user->update($data)){

                return redirect()->route('user')->with(['success' => 'User was updated.']);

            }else{
                $errors['message'] = 'error on save';
            }
            

        }else{
            $errors = $validator;
        }

        return redirect()->back()->withErrors($errors);
    }

    public function destroyConfirm($email = null, User $User){
        if(empty($email)) return redirect()->route('Panel')->withErrors(['message' => 'invalid request.']);

        $user = $User->where('email', $email)->first();

        if(!$user) return redirect()->route('Panel')->withErrors(['message' => 'invalid request.']);

        $action = route('deleteConfirmed', $email);

        $id = $user->id;
        $this->Menu->setActive('User');
        $menu = $this->Menu->build();
        return view('deleteConfirm', compact('menu', 'action', 'id'));
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $User){

        $user = $User->find($request->input('id'));

        if(empty($user))
            return redirect()->route('home')->withErrors(['message' => 'Invalid request.']);

        if($user->id == Auth::User()->id || 
            Auth::User()->level()->first()->permission == 777){


            
                if($user->level()->first()->permission == 777){

                    $admin = $User->where('level_id', $user->level_id)->get()->count();

                    if($admin > 1){

                        if(!$user->delete())
                            return redirect()->route('home')->withErrors(['message' => 'internal error.']);

                    }else{

                        return redirect()->route('home')->withErrors(['message' => '<u>Unauthorized</u> </p>It is not possible to delete the only administrator.<p>']);

                    }

                }else{

                    if(!$user->delete())
                        return redirect()->route('home')->withErrors(['message' => 'internal error.']);

                }
        }else{

            return redirect()->route('home')->withErrors(['message' => 'unauthorized']);

        }

        return redirect()->route('home')->with(['success' => 'User was deleted']);
    }
}

