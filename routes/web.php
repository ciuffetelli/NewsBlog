<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/teste', function () {

    $data = DB::table('dwg')
    // ->select('dwg.id as id, dwg.description as description, dwg.data as calloff, calloff.data as data')
        ->select(DB::raw('dwg.id, dwg.description'))
                    // ->leftJoin('drawing_details as dt','dwg.id','=','dt.id_number')
                    // ->leftJoin('calloff', 'dwg.id', '=', 'calloff.dwg_number')
                        // ->where('dwg.id', 516)
                        ->get();

    $drawings = $data->map( function ($line) {

        $json = DB::table('calloff')->where('dwg_number', $line->id)->first();

        if($json && $json->data){            


            $jsonReturn = (array) $json;
            $jsonData = json_decode($json->data);
            unset($jsonReturn['data']);

            $index = 0;
            foreach($jsonData as $json){
                $jsonReturn["CallOff $index"] = implode(' | ', (array) $json);
                $index++;
            }

            $toReturn = array_merge($jsonReturn, (array) $line);
        }else{
            $toReturn = $line;
        }

        return $toReturn;
    });

    // dd($drawings);

    // dd(
    //     json_encode([
    //         ['nome' => 'Daniel', 'sobrenome' => 'Barroso'],
    //         ['nome' => 'Lorenna', 'sobrenome' => 'Rocha']
    //     ])
    // );                     

    // echo json_encode($drawings);

    // $drawings = json_encode($drawings);

    // dd($drawings);
    return view('teste', compact('drawings'));
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');

Route::get('/search', 'HomeController@search')->name('search');
Route::get('/category/{categoryName}', 'HomeController@category')->name('openCategory');
Route::get('/by_user/{userName}', 'HomeController@byUser')->name('openUser');

Route::get('/article', 'HomeController@article')->name('viewArticle');
    Route::get('/article/{id}', 'HomeController@article')->name('openArticle');

Auth::routes();
Route::get('/logout', function (){
    Auth::logout();
    return redirect()->route('home');
});
    

// Route::get('/article', 'Panel\ArticleController@show')->name('viewArticle');
//     Route::get('/article/{id}', 'Panel\ArticleController@show')->name('openArticle');

Route::get('/help', 'HelpController@index')->name('help');

Route::middleware(['auth'])->prefix('Panel')->namespace('Panel')->group(function(){

    Route::get('/', 'PanelController@index')->name('admin');

    Route::prefix('article')->group(function (){

        Route::get('/', 'ArticleController@index')->name('article');

        Route::get('/form', 'ArticleController@create')->name('newArticle');
            Route::post('/form', 'ArticleController@store');

            Route::get('/form/{id}', 'ArticleController@edit');
                Route::post('/form/{id}', 'ArticleController@update');

            Route::get('/delete', 'ArticleController@destroyConfirm')->name('deleteArticle');
                Route::get('/delete/{id}', 'ArticleController@destroyConfirm');
                    Route::post('/delete', 'ArticleController@destroy');

        Route::get('/api', 'ArticleController@api')->name('apiArticle');
    });


    Route::prefix('category')->group(function () {
        Route::get('/', 'CategoryController@index')->name('category');

        Route::get('/form', 'CategoryController@create')->name('newCategory');
            Route::post('/form', 'CategoryController@store');

            Route::get('/form/{id}', 'CategoryController@show');
                Route::post('/form/{id}', 'CategoryController@update');

        Route::get('/delete', 'CategoryController@destroyConfirm')->name('deleteCategory');
            Route::get('/delete/{id}', 'CategoryController@destroyConfirm');
                Route::post('/delete', 'CategoryController@destroy');

        Route::get('/api', 'CategoryController@api')->name('apiCategory');
    });


    Route::prefix('user')->group(function () {
        Route::get('/', 'UserController@index')->name('user');
            Route::get('/{email}', 'UserController@edit')->name('myUser');
                Route::post('/{email}', 'UserController@update');
        
        Route::get('/delete', 'UserController@destroyConfirm')->name('deleteUser');
            Route::get('/delete/{email}', 'UserController@destroyConfirm');
                Route::post('/delete/{email}', 'UserController@destroy')->name('deleteConfirmed');
    });

    // Route::prefix('api')->group(function (){
    //     Route::get('/article', 'ArticleController@index')->name('apiArticle');
    // });
});

